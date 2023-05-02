<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Controllers\PaginationController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
Use Str;
use Illuminate\Support\Facades\Validator;

/**
 * Controller Class to manipulate the Category Model Objects
 * Defines and enforces data validation rules
 * 
 * @author Marino Giudice
 */

class CategoryController extends Controller
{
    /**
     * Displays the categoies view.
     * gets the categories list from the model
     * invokes the oagination controller to paginate the results
     * passes to the view
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $categories = Category::getCategories();
        $paginatedCategories=PaginationController::paginateArray($request, $categories);
        return view('admin.categories.categories',['categories'=>$categories, 'paginatedCategories' => $paginatedCategories]);
    }

    /**
     * Shows the add category view.
     * gets the category list from the moel to be 
     * siaplayed in the select option element
     * assign a default value to the category parameter.
     * it is used also to create subcategories
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Category $category = null)
    {   
        $categories = Category::getCategories();
        if($category !==null) {    
            return view('admin.categories.addcategory', ['categories' => $categories, 'category' => $category] );
        }
        return view('admin.categories.addcategory', ['categories' => $categories] );
    }


    /**
     * Stores a category object into the database
     * Takes the Request and the Category as parameter
     * Assigns a default value to the category parameter
     * Use the FileUploadController to upload a file in the server
     */

    public function store(Request $request, Category $category = null) {
        //validates the user input
        $request->validate([
            'category_name' =>'bail|required|bail|max:20|bail|unique:categories|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 ]*)?$)/',
            'category' => Rule::when($category === null,['required']),
            
        ]);
        $imagePath=null;
        //checks if the request has a file
       if($request->hasFile('file')) {
           //validates the file format and weight
            $request->validate([
                'file' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            //moves the file in the server
            $imagePath =FileUploadController::uploadFile($request->file,'categories',$request->category_name);
            if(!$imagePath) {
                return redirect()->back()->with('fail', 'Impossible to Complete File Upload Internal Error');
            }
        }
        //creates the category Model object
        $categoryMod =new Category;
        $categoryMod->category_name = Str::lower($request->input('category_name'));
        $categoryMod->image_path = $imagePath;
        //checks if the category in input is master
        if($category === null) {
            $categoryMod->parent_category = $request->input('category');
            if($request->input('category')==='master') {
                $categoryMod->parent_category = null;
            }
        }
        else {
            $categoryMod->parent_category = Str::lower($category->category_name);
        }
        //stores in the db
        if(!$categoryMod->save()) {
            return redirect('/admin/categories')->with('fail', 'Impossible to add New Category Db Error');
        }
        return redirect('/admin/categories')->with('success', 'New Category added Successfully');
    }

    /**
     * Display the subcategories of a category
     * Takes as parameter the category and request
     * injects the results into the categories view
     * 
     */
    
    public function show(Request $request, Category $category)
    {
        $categories = Category::getCategories();
        $categoriesOf = Category::getCategoriesOf($category);
        $paginatedCategories=PaginationController::paginateArray($request, $categoriesOf);
        return view('admin.categories.categories',['categories'=>$categories, 'paginatedCategories' => $paginatedCategories, 'name' => $category->category_name]);
    }

    /**
     * Shows the editcategory view.
     * gets the categories list from the db to pass to the select option element.
     * gets from the db the children categories of the parameter category
     */

    public function edit(Category $category)
    {
        $categories = Category::getCategories();
        $parent=$category->getParent()->first();
        $children=$category->categories()->get();
        if($parent === null) {
            $parent = new Category;
            $parent->category_name = 'master';
        }
        return view('admin.categories.edit',['categories' => $categories, 'category' => $category, 'children' => $children]);
    }

    /**
     * Shows the updates category view
     *  
     */
    public function update(Request $request, Category $category)
    {
        //validates the form inputs
        $request->validate([
            'category_name' =>'bail|required|bail|max:20|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 ]*)?$)/|bail|unique:categories,category_name,'.$category->category_name.',category_name',
            'category' => 'different:category_name|required',
        ]);
        $imagePath=$category->image_path;
        //checks if the request contains a file
        if($request->hasFile('file')) {
            //validates the file extension and weight
            $request->validate([
                'file' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            //upload the new file on the server
            $imagePath =FileUploadController::uploadFile($request->file,'categories',$request->category_name);
            if(!$imagePath) {
                return redirect()->back()->with('fail', 'Impossible to Complete File Upload Internal Error');
            }
        }
        //gets the specified category from the db
        $categoryMod = Category::where('category_name',$category->category_name)->first();
        $children_categories=null;
        $children_products=null;
        //checks if the category is been renamed
        if(!($category->category_name == Str::lower($request->input('category_name')))) {
            $children_categories=$category->categories()->get();
            $children_products=$category->products()->get();
            if($category->image_path){
                $imagePath=FileUploadController::renameFile($category->image_path, $request->input('category_name'), 'categories');
            }
            $category->delete();
        }
        $category->category_name = Str::lower($request->input('category_name'));
        
        $name=$category->category_name;
        
        $category->image_path = $imagePath;
            if($request->input('category')==='master') {
                $category->parent_category = null;
            }
        
        else {
            $category->parent_category = Str::lower($request->input('category'));
        }
        if(!$category->save()) {
            return $this->index($request)->with('fail', 'Impossible to update Category Db Error');
            
        }
        //if the category is been renamed updates the parent field of its children categories
        if($children_categories) {
            foreach($children_categories as $child) {
                $child->update(['parent_category' => $name]);
            }
        }
        //if the category is been renamed and has children products updates its products parent field 
        if($children_products) {
            foreach($children_products  as $child) {
                $child->update(['product_category' => $name]);
            }
        }
        return redirect('/admin/categories')->with('success', 'Category updated Successfully');
    }

    /**
     * Deletes the specified category from the db
     *
     * @param  Category  $category
     * @return \Illuminate\Http\Response
     */

    public function destroy(Category $category)
    {
        //if has picture delete the picture
        if($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        //delete the db row
        $category->delete();
        return redirect('/admin/categories')->with('success', 'Category Deleted');
    }

    /**
     * The function is used for the list results filter.
     */

    public function filterCategories(Request $request) {
        //validates the search parameter
        $request->validate(['category' => 'required|string'
    ]);
        $name=$request->category;
        $categories=Category::getCategories();
        if($name === 'master') {
            //gets the master categories if the selected category value is master
            $paginatedCategories = Category::where('parent_category',null)->paginate(5);
            //returns the results to the view
            return view('admin.categories.categories', ['categories' =>$categories,'paginatedCategories' => $paginatedCategories, 'name' => null]);
        }
        //gets the children of the selected category and their children
        $name = Category::find($name);
        $result = Category::getCategoriesOf($name);
        //paginates the result
        $paginatedCategories=PaginationController::paginateArray($request, $result);
        //return the results to the view
        return view('admin.categories.categories', ['categories' =>$categories,'paginatedCategories' => $paginatedCategories, 'name' => $name->category_name]);
    }

    /**
     * The function is used to delete a picture of a category
     */
    
    public function deletePic(Category $category) {
        if($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
            $category->image_path=null;
            
            $category->save();
        }
        return redirect()->back()->with('success','Image Deleted');
    }

}

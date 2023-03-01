<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Session;
use Str;

/**
 * Controller Class to manipulate the Product Model Objects
 * Defines and enforces data validation rules
 * 
 * @author Marino Giudice
 */

class ProductController extends Controller
{
    /**
     * Displays the products index page
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //gets the categories list
        $categories = Category::getCategories();
        //gets the products list and paginate
        $products = Product::paginate(10);
        return view('admin.products.products',['categories' => $categories, 'products'=> $products]);
    }

    /**
     * Show the view to create a new product.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::getCategories();
            return view('admin.products.addproduct', ['categories' => $categories] );
    }

    /**
     * Store a new product in the database
     * works like the store function of the CategoryController.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {
        $request->validate([
            //validates the input fields
            'product_name' =>'bail|required|bail|max:30|bail|unique:products|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 ]*)?$)/',
            'category' => 'required',
            'product_description' => 'bail|max:50|nullable|regex:/(^(([a-zA-Z0-9.,:óíúéá ]*)+)([A-Za-z0-9.,:óíúéá ]*)?$)/',
            'product_price' => 'numeric',
        ]);
        $imagePath=null;
        //checks if there is a file
       if($request->hasFile('file')) {
            $request->validate([
                'file' => 'image|mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            //moves the file on the server
            $imagePath =FileUploadController::uploadFile($request->file,'products',Str::lower($request->product_name));
            if(!$imagePath) {
                return redirect()->back()->with('fail', 'Impossible to Complete File Upload Internal Error');
            }
        }
        //creates the new product object
        $product =new Product;
        $product->product_name = Str::lower($request->input('product_name'));
        $product->product_description=($request->input('product_description'));
        $product->product_pic = $imagePath;
        $product->product_price = $request->input('product_price');
        if($request->input('category')==='master') {
            $product->product_category = null;
        }
        else {
            $product->product_category = Str::lower($request->input('category'));
        }
        //stores the new product into the db
        if(!$product->save()) {
            return redirect('/admin/products')->with('fail', 'Impossible to add New Product Db Error');
        }
        return redirect('/admin/products')->with('success', 'New Product added Successfully');
    }

    /**
     * Shows the edit product view.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::getCategories();
        $parent=$product->parent_category;
        if($parent === null) {
            $parent = new Product;
            $parent->product_category = 'master';
        }
        return view('admin.products.edit',['categories' => $categories, 'product' => $product]);
    }

    /**
     * Update the specified product in the db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Product $product)
    {
        //validates the form inputs
        $request->validate([
           'product_name' =>'bail|required|bail|max:30|bail|regex:/(^(([a-zA-Z0-9]*)+)([A-Za-z0-9 .,:óíúéá]*)?$)/|bail|unique:products,product_name,'.$product->product_name.',product_name',
            'category' => 'required',
            'product_price' => 'numeric',
        ]);
        $imagePath=$product->product_pic;
        if($request->hasFile('file')) {
            $request->validate([
                'file' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            $imagePath =FileUploadController::uploadFile($request->file,'products',$request->product_name);
            if(!$imagePath) {
                return redirect()->back()->with('fail', 'Impossible to Complete File Upload Internal Error');
            }
        }
        //if the products is been renamed 
        if(!($product->product_name == Str::lower($request->input('product_name')))) {
            if($product->product_pic){
                //renames the associated picture file
                $imagePath=FileUploadController::renameFile($product->product_pic, $request->input('product_name'), 'products');
            }
        }
        //updates the product object
        $product->product_name = Str::lower($request->input('product_name'));
        $product->product_pic = $imagePath;
        $product->product_description=($request->input('product_description'));
        $product->product_price= $request->input('product_price');
        if($request->input('category')==='master') {
            $product->product_category = null;
        }
        else {   
            $product->product_category = Str::lower($request->input('category'));
        }
        //write into the db
        if(!$product->save()) {
            return $this->index($request)->with('fail', 'Impossible to update Product Db Error');
        }
        return redirect('admin/products')->with('success', 'Product updated Successfully');
    }

    /**
     * Deletes the specified product from the db.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //if the product has a picture
        if($product->product_pic) {
            //delete the picture
            Storage::disk('public')->delete($product->product_pic);
        }
        //delete the product from the db
        $product->delete();
        return redirect('/admin/products')->with('success', 'Product Deleted');
    }

    //deletes the picture from the server and the db
    public function deletePic(Product $product) {
        if($product->product_pic) {
            Storage::disk('public')->delete($product->product_pic);
            $product->product_pic=null;
            $product->save();
            
        }
        return redirect()->back()->with('success','Image Deleted');
    }

    // the function returns the filtered results of the product listing
    public function filterProducts(Request $request) {
        $request->validate(['category' => 'required|string'
    ]);
        $name=$request->category;
        $categories = Category::getCategories();
        if($name === 'master') {
            $products= Product::where('product_category', null)->paginate(10);
            return view('admin.products.products',['categories' =>$categories,'products' => $products, 'name' => 'Master']);
        }
        $products=Product::where('product_category',$name)->paginate(10);
        return view('admin.products.products', ['categories' => $categories, 'products' => $products, 'name' =>$name]);
    }

    //the function adds a product to the cart
    public function addToCart(Request $request, Product $product) {
        //gets the cart from the session if any, create a new one otherwise
       $oldCart = Session::has('cart') ? $request->session()->get('cart') : null;
        $cart = new Cart($oldCart);
        //adds the product to the cart
        $cart->add($product);
        //put the cart in the session
        session(['cart' => $cart]);
        return redirect('/ordering') ;
    }
}


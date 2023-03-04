<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Product;
use Arr;

/**
 *
 * The Class defines the Category Model Object
 * 
 * @author Marino Giudice
 */

class Category extends Model
{
    //disables the autoincrement for the primary key value
    public $incrementing = 'false';
    //set category_name as primary key instead of the defaul field 'id'
    protected $primaryKey = 'category_name';
    //sets the primary key type
    protected $keyType = 'string';
    //specifies the fields that can be filled by mass assignment.
    protected $fillable = ['category_name','parent_category'];

    /**
     * The method returns the children categories of a category
     * 
     */
    
    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_category')->orderBy('category_name','ASC');
    }

    /**
     * The method returns all the children of the children categories of a category.
     * Uses the method categories to obtain the first level of children. 
     */

    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_category')->with('categories')->orderBy('category_name','asc');
    }

    /**
     * The method returns a collection of Category Object present in the categories database table.
     * Uses the childrenCategories method to obtain all the children categories of the categories of lowest depth.
     * The categories of lowest level have null value as parent_category.
     * Uses the method loadCategoriesCollection to return a Collection.
     */

    public static function getCategories () {
        $categories = Category::where('parent_category', null)->with('childrenCategories')->orderBy('category_name','ASC')->get();
        return Category::loadCategoriesCollection($categories);
    }

    /**
     * The function returns the children categories of a Category 
     * Takes a category name as parameter.
     * 
     */

    public static function getCategoriesOf (Category $category) {
        $categories = Category::where('parent_category',$category->category_name)->with('childrenCategories')->orderBy('category_name','ASC')->get();
        return Category::loadCategoriesCollection($categories);
    }

    /**
     * The method flatten the recursive structure of the categories table.
     * To each element of the collection is assigned is depth from the root elements
     * Returns a Collection
     * Takes as parameter an Eloquent Collection 
     */

    public static function loadCategoriesCollection($categories) {
        $result=collect();
        $depth=0;
        foreach($categories as $category) {
            $result->push(collect(['category'=> $category, 'depth'=>$depth]));
            foreach($category->childrenCategories as $childCategory) {
                $result=Category::child_category($childCategory, $depth,$result);
                
            }
        }
        return $result;
    }

    public function getParent() {
        return $this->belongsTo(Category::class, 'parent_category');
    }

    public static function child_category($child_category, $parentDpt, $result) {
        $depth=$parentDpt;
        $depth++;
        $result->push(collect(['category'=> $child_category, 'depth'=>$depth]));
        if($child_category->categories) {
            foreach($child_category->categories as $childCategory) {
                $result=Category::child_category($childCategory,$depth,$result);
            } 
        }
        $depth--;
        return $result;
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_category',)->orderBy('product_category','ASC');
    }
}
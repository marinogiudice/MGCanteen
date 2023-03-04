<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * The class performs pagination operations on arrays or collections .
 * It's used to paginated the results from the categories database table
 * 
 */

class paginationController extends Controller
{   
    /**
     * The function paginates the data
     * Takes as parameter the request and the data to paginate
     */
    public static function paginateArray (Request $request, $data) {

    
    // Create a new  collection from data
    $productCollection = collect($data);

    // Defines the page length
    $perPage = 10;

    // Gets the current page number from the url
    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    // Chuncks the collection and injects it in the current page
    $currentCategoryPage = $productCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

    // Creates a paginator and pass it to the view with the current chunck for the current page
    $paginatedCategories= new LengthAwarePaginator($currentCategoryPage , count($productCollection), $perPage);

    // generates the results pages urls
    $paginatedCategories->setPath($request->url());
    

    return $paginatedCategories;
    //return view('categories', ['data' => $paginatedCategories]);


    }
}

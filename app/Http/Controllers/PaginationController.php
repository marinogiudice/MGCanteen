<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * The class performs pagination operations on arrays or collections .
 * It's used to paginated the results from the categories or products database table
 * 
 * @author Marino Giudice
 * 
 */

class PaginationController extends Controller
{   
    /**
     * The function paginates the data
     * Takes as parameter the request and the data to paginate
     */
    public static function paginateArray (Request $request, $data) {

    
    // Create a new  collection from data
    $itemsCollection = collect($data);

    // Defines the page length
    $perPage = 10;

    // Gets the current page number from the url
    $currentPage = LengthAwarePaginator::resolveCurrentPage();

    // Chuncks the collection and injects it in the current page
    $currentItemsPage = $itemsCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

    // Creates a paginator and pass it to the view with the current chunck for the current page
    $paginatedItems= new LengthAwarePaginator($currentItemsPage , count($itemsCollection), $perPage);

    // generates the results pages urls
    $paginatedItems->setPath($request->url());
    

    return $paginatedItems;
    }
}

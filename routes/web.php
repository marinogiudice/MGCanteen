<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\OrderingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
*/

//sets the login route
Route::get('/admin/login',[AuthenticationController::class, 'index'])->name('login');
//sets the route for the login form post request. Calls the AuthenticationController tryLogin function.
Route::post('/admin/trylogin', [AuthenticationController::class, 'tryLogin']);


//groups the route under the admin prefix. Protects the access of the routes to unauthenticated user by the Auth Middleware
Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {

    //defines the route for the logOut AuthenticationController method.
    Route::get('logout', [AuthenticationController::class, 'logOut']);
    //defines the route for the management home page returns a view.
    Route::get('/', [AuthenticationController::class, 'index']);
   
    //sets the route for the categories filter form post request, calls the Category Controller filterCategories method.
    Route::post('categories/filter', [CategoryController::class,'filterCategories']);
    //sets the route for the create a category get request. Calls the CategoryController create method.
    Route::get('categories/create/{category?}', [CategoryController::class, 'create']);
    //sets the route for the create a category post request. Calls the CategoryController store method.
    //takes the category as parameter. The parameter can be null.
    Route::post('categories/{category?}', [CategoryController::class,'store']);
    //sets the route for the delete picture post request. Calls the Category Controller deletePic method.
    //takes the category as parameter.
    Route::post('categories/{category}/delpic',[CategoryController::class,'deletePic']);
    //sets the routes for the operation of create, update and delete for the Category Class. To each of these operation is assigned a method
    //like create update and destroy. 
    Route::resource('categories', CategoryController::class);
    
    /**
     * The following lines sets the same route as above but for the products and tables model classes.
     * They Call the respective controllers.
     */

    Route::post('products/{product}/delpic',[ProductController::class,'deletePic']);
    Route::post('products/filter',[ProductController::class, 'filterProducts']);
    Route::resource('products', ProductController::class);

    Route::post('tables/filter', [TableController::class,'filterTables']);
    Route::resource('tables', TableController::class);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/{order}', [OrderController::class, 'show']);

});

//route to the public index
Route::get('/', function (){
    $cart=null;
    if(Session::has('cart')) {
        $cart=Session::get('cart');
    }
    return view('public.index', ['cart' => $cart]);
});

//routes to the ordering component are public

//routes to the ordering component page
Route::get('/ordering', [OrderingController::class, 'index']);
//route to show the items in an ordering page
Route::get('/ordering/{category?}', [OrderingController::class, 'showCategory']);
//route to add a product to the cart
Route::get('/ordering/addtocart/{product}', [ProductController::class, 'addToCart']);
//route to show the cart
Route::get('/ordering/order/cart', [CartController::class, 'show']);
//route to the proceed view
Route::get('/ordering/order/cart/proceed', [CartController::class, 'proceed']);
//route to delete a cart item
Route::delete('/ordering/cart/{product}',[CartController::class, 'destroy']);
Route::post('/ordering/order/confirm/',[OrderController::class,'store']);
//route to the order confirmation
Route::get('/ordering/order/yourorder/{order}', [OrderingController::class, 'showOrder']);

Route::get('/contactus', [MailController::class, 'index']);
Route::post('/contactus/sendmessage', [MailController::class, 'send_message']);

    









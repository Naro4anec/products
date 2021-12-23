<?php

use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//*/

Route::apiResources([
    'product' => ProductController::class,
    'shop' => ShopController::class
]);

//Route::get('product/list', [ProductController::class, 'getList'])->name('api-product-list');
//Route::get('shop/list', [ShopController::class, 'getList'])->name('api-shop-list');
//Route::get('shop/working', [ShopController::class, 'getWorkingList'])->name('api-shop-working');

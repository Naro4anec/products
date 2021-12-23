<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function getList()
    {
        /*/
        $prod = new Product();
        $prod->name = 'Носок';
        $prod->description = '<h1>Крутой носок</h1>';
        $prod->price = 2.75;
        $prod->shop_id = 1;
        $prod->save();
        //*/

        return new ProductCollection(Product::all());
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function products()
    {
        $fakeProductList = [
            [
                'name' => 'Носок мужской "Бэтмен"'
                ,'qnty' => 20
                ,'price' => 4.0
            ]
            ,[
                'name' => 'Майка женская "Финч"'
                ,'qnty' => 2
                ,'price' => 15.0
            ]
        ];
        return ['products' => $fakeProductList];
    }
}

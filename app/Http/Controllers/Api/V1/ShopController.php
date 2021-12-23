<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ShopController extends Controller
{
    public function getList()
    {
        $shop = new Shop;
        $dateObj = new \DateTime();
        $nowTime = $dateObj->format('H:i:s');
        unset($dateObj);


        return $shop
            ->where('id', '>', 2)
            ->where('working_time_open', '<', $nowTime)
            ->where('working_time_close', '>', $nowTime)
            ->get();
        /*/
        return new ShopCollection(Cache::remember('shop-list', 60*60*24, function () use {
            return Shop::all();
        }));
        //*/
    }
}

<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;
use App\Models\Shop;
use App\Services\ShopExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Exports\ShopsExport;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : ShopCollection
    {
        return new ShopCollection(Cache::remember('shop-list', 60*60*24, function () {
            return Shop::all();
        }));
    }

    public function export(ShopExportService $service) : array
    {
        $fileUrl = $service->export();
        $result = [
            'status' => 'success'
        ];
        if(!empty($fileUrl)){
            $result['url'] = $fileUrl;
        }else{
            $result['status'] = 'error';
            $result['message'] = 'Ошибка экспорта.';
        }
        return $result;
    }

}

<?php


namespace App\Services;


use App\Exports\XML\MultipleElement;
use App\Exports\XML\SimpleElement;
use App\Exports\XML\Structure;
use App\Exports\XMLExport;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ShopCollection;
use App\Models\Product;
use App\Models\Shop;

class ShopExportService
{
    /**
     * @return Structure
     * @throws \Exception
     */
    protected function makeXMLStruct() : Structure
    {
        $struct = new Structure();

        $shop = new MultipleElement('shop');
        $struct->setBaseElement($shop);
        $shop->setAttribute('id');

        $shop->addData(new SimpleElement('name'));
        $shop->addData(new SimpleElement('url'));

        $workingTime = new MultipleElement('working_time');
        $workingTime->addData(new SimpleElement('open', 'working_time_open'));
        $workingTime->addData(new SimpleElement('close', 'working_time_close'));
        $shop->addData($workingTime);
        unset($workingTime);

        $offers = new MultipleElement('offers');
        $offers->setMulti('products');
        $offerData = new MultipleElement('item');
        $offerData->setAttribute('id');
        $offerData->addData(new SimpleElement('name'));
        $offerData->addData(new SimpleElement('description'));
        $offerData->addData(new SimpleElement('price'));
        $offers->addData($offerData);
        $shop->addData($offers);
        unset($offerData, $offers);

        return $struct;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function export() : string
    {
        $shopList = $this->getWorkingShopList();
        $this->formatShopList($shopList);
        $shopIds = $shopList->pluck('id')->toArray();
        $productList = $this->getProductListByShops($shopIds);
        $this->formatProductList($productList);

        $productLinks = [];
        foreach ($productList as &$product)
        {
            if(!isset($productLinks[$product->shop_id])){
                $productLinks[$product->shop_id] = [];
            }
            $productLinks[$product->shop_id][] = $product;
        }

        foreach ($shopList as &$shop){
            $shop['products'] = null;
            if(!isset($productLinks[$shop->id])){
                continue;
            }
            $shop['products'] = ProductCollection::make($productLinks[$shop->id]);
        }

        $exportObj = new XMLExport('shops');
        $exportObj->fillData($shopList);
        $exportObj->setStructure($this->makeXMLStruct());

        $result = '';
        if($exportObj->makeFile()){
            $result = '/storage'.$exportObj->getFilePath().$exportObj->getFileName();
        }
        return $result;
    }

    /**
     * @return ShopCollection
     * @throws \Exception
     */
    public function getWorkingShopList() : ShopCollection
    {
        $shop = new Shop;
        $dateObj = new \DateTime();
        $nowTime = $dateObj->format('H:i:s');
        unset($dateObj);

        return new ShopCollection($shop
            ->where(function($q) use ($nowTime){
                $q->where('working_time_open', '<=', $nowTime)
                    ->where('working_time_close', '>', $nowTime)
                ;
            })
            ->orWhere(function($q) use ($nowTime){
                $q->whereColumn('working_time_open', '>=', 'working_time_close')
                    ->where(function($q) use ($nowTime){
                        $q->where('working_time_open', '<=', $nowTime)
                            ->orWhere('working_time_close', '>', $nowTime)
                        ;
                    });
            })
            ->get()
        );
    }

    /**
     * @param array $shopIds
     * @return ProductCollection
     */
    public function getProductListByShops(array $shopIds) : ProductCollection
    {
        $product = new Product;
        return new ProductCollection($product
            ->whereIn('shop_id', $shopIds)
            ->get()
        );
    }

    /**
     * @param $collection
     */
    public function formatShopList(&$collection) : void
    {
        foreach ($collection as &$item){
            $item['working_time_open'] = substr($item['working_time_open'], 0, 5);
            $item['working_time_close'] = substr($item['working_time_close'], 0, 5);
        }
    }

    /**
     * @param $collection
     */
    public function formatProductList(&$collection) : void
    {
        foreach ($collection as &$item){
            $item['description'] = strip_tags(htmlspecialchars_decode($item['description']));
        }
    }


}

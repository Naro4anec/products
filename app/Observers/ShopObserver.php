<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class ShopObserver
{
    const CACHE_KEY_LIST = 'shop-list';
    //
    public function created()
    {
        Cache::forget(self::CACHE_KEY_LIST);
    }

    public function saved()
    {
        Cache::forget(self::CACHE_KEY_LIST);
    }

    public function deleted()
    {
        Cache::forget(self::CACHE_KEY_LIST);
    }

}

<?php

namespace ElcoBvg\Opcache;

use Illuminate\Cache\TagSet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public static function boot()
    {
        Cache::extend('opcache', function () {
            $store = new Store;
            return new Repository($store, new TagSet($store));
        });

        // Extend Collection to implement __set_state magic method
        if (! Collection::hasMacro('__set_state')) {
            Collection::macro('__set_state', function (object $array) {
                $obj = new Collection;
                $obj->items = $array->items;
                return $obj;
            });
        }
    }
}

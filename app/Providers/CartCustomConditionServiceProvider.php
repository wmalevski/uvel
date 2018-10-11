<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

Class CartCustomConditionServiceProvider extends ServiceProvider {
    public function register(){
        $this->app->bind('cartcustomcondition.cart', function(){
           return new CartFacade($this->app['config']);
        });
    }
}

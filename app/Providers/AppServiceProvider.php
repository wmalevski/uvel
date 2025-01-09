<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserRole;
use App\Observers\UserGroupObserver;
use App\Observers\UserObserver;
use App\Role\RoleChecker;
use App\User;
use App\UserGroup;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\+?)([0-9] ?){9,30}$/', $value) && strlen($value) >= 10;
        });

        Validator::replacer('phone', function($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute',$attribute, ':attribute е невалиден.');
        });

        Validator::extend('recaptcha', 'App\Rules\Recaptcha@passes');

        Paginator::useBootstrap();

        UserGroup::observe(UserGroupObserver::class);
        User::observe(UserObserver::class);
    	LogViewer::auth(function ($request) {
        	return $request->user()
            	&& in_array($request->user()->email, [
                	'admin@uvel.com',
            	]);
    	});
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckUserRole::class, function(Application $app) {
            return new CheckUserRole(
                $app->make(RoleChecker::class)
            );
        });
    }
}

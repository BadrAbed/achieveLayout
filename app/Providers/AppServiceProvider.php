<?php

namespace App\Providers;

use App\Http\Controllers\LogTimeController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //LogTimeController::saveLogesTimes('dd');
        Schema::defaultStringLength(191);

        Validator::extend('greater_than_field', function ($attribute, $value, $parameters, $validator) {
            $min_field = $parameters[0];
            $data = $validator->getData();
            $min_value = $data[$min_field];
            return $value > $min_value;
        });
        Validator::extend('greater_than_now', function ($attribute, $value, $parameters, $validator) {

            return $value >= date("Y-m-d");
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public
    function register()
    {
        //
    }
}

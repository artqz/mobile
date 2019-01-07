<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use \Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191); //Solved by increasing StringLength
        Resource::withoutWrapping();

        Relation::morphMap([
            'armor' => 'App\Armor',
            'weapon' => 'App\Weapon',
            'etc' => 'App\Etc',
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

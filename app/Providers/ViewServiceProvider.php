<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Models\Role;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['users.create', 'users.edit'], function ($view) {
            return $view->with(
                'roles',
                Role::select('id', 'name')->get()
            );
        });


        View::composer(['tickets.create', 'tickets.edit'], function ($view) {
            return $view->with(
                'devices',
                \App\Models\Device::select('id', 'dev_eui')->get()
            );
        });

        View::composer(['parseds.create', 'parseds.edit'], function ($view) {
            return $view->with(
                'devices',
                \App\Models\Device::select('id', 'dev_eui')->get()
            );
        });

        View::composer(['parseds.create', 'parseds.edit'], function ($view) {
            return $view->with(
                'rawdatas',
                \App\Models\Rawdata::select('id', 'dev_eui')->get()
            );
        });


        View::composer(['kabkots.create', 'kabkots.edit'], function ($view) {
            return $view->with(
                'provinces',
                \App\Models\Province::select('id', 'provinsi')->get()
            );
        });

        View::composer(['kecamatans.create', 'kecamatans.edit'], function ($view) {
            return $view->with(
                'kabkots',
                \App\Models\Kabkot::select('id', 'kabupaten_kota')->get()
            );
        });


        View::composer(['kelurahans.create', 'kelurahans.edit'], function ($view) {
            return $view->with(
                'kecamatans',
                \App\Models\Kecamatan::select('id', 'kecamatan')->get()
            );
        });
    }
}

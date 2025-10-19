<?php

namespace App\Providers;

use App\Models\WebSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        View::composer('*', function ($view) {

            $view->with([
                'nama_app' => WebSetting::where('name', 'nama_app')->first()->isi,
                'main_logo' => WebSetting::where('name', 'logo')->first()->isi,
            ]);
        });
    }
}

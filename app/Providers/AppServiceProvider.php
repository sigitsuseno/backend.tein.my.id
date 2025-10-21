<?php

namespace App\Providers;

use App\Models\WebSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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

        // if (config('app.env') !== 'local') {
        //     URL::forceScheme('https');
        // }

        View::composer('*', function ($view) {
            $main_logo_path = WebSetting::where('name', 'logo')->value('isi');
            $view->with([
                'nama_app' => WebSetting::where('name', 'nama_app')->first()->isi ?? 'Tein APP',
                'main_logo' => $main_logo_path ? '/storage/'.$main_logo_path : '/assets/logo.png',
                'keyname' => Auth::check() ? Auth::user()->username ?? Auth::user()->uuid : 'member',
            ]);
        });
    }
}

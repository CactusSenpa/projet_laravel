<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (! Schema::hasTable('settings')) {
                $view->with('whatsappUrl', 'https://wa.me/21620000000');
                $view->with('companyName', 'WattLoc');

                return;
            }

            $view->with('whatsappUrl', whatsapp_url());
            $view->with('companyName', Setting::getValue('company_name', 'WattLoc'));
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Broadcast::routes();
        //require base_path('routes/channels.php');

        Paginator::useBootstrapFive();
        //Paginator::useBootstrapFour();
    }
}

<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        // Cache::forget("topUsers");

        $topUsers = cache()->remember('topUsers', now()->addMinutes(5), function () {
            return User::withCount('ideas')
                ->orderBy('ideas_count', 'desc')
                ->limit(5)->get();
        });

        View::share(
            'topUsers',
            $topUsers
        );
    }
}

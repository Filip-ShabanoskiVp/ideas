<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //Gate - Permission | Role

        //Role
        Gate::define("admin", function (User $user) : bool{
        return (bool) $user->is_admin;
        });

        //Permission
        // Gate::define("idea.delete", function (User $user,Idea $idea) : bool{
        //     return ((bool) $user->is_admin || $user->id === $idea->user_id);
        // });

        // Gate::define("idea.edit", function (User $user, Idea $idea) : bool{
        //     return ((bool) $user->is_admin || $user->id === $idea->user_id);
        // });
    }
}

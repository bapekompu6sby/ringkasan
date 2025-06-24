<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });
        Gate::define('petugas', function ($user) {
            return $user->isPetugas();
        });
        Gate::define('supervisi', function ($user) {
            return $user->isSupervisi();
        });
        Gate::define('admin-or-petugas', function ($user) {
            return $user->isAdmin() || $user->isPetugas();
        });
        Gate::define('admin-or-supervisi', function ($user) {
            return $user->isAdmin() || $user->isSupervisi();
        });
        Gate::define('petugas-or-supervisi', function ($user) {
            return $user->isPetugas() ||  $user->isSupervisi();
        });
    }
}

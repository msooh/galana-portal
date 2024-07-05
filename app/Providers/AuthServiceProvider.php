<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage_dealers', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Retail Manager');
        });
    
        Gate::define('manage_stations', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Retail Manager');
        });

        Gate::define('manage_station_managers', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Retail Manager');
        });
    
        Gate::define('Territory Manager (TM)', function ($user) {
            return $user->hasRole('Territory Manager (TM)');
        });

        Gate::define('manage_checklists', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Retail Manager');
        });

        Gate::define('manage_safeties', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Hsseq');
        });
        
        Gate::define('manage_users', function ($user) {
            return $user->hasRole('Admin') || $user->hasRole('Retail Manager');
        });
    }
}

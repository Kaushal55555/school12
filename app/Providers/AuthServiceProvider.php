<?php

namespace App\Providers;

use App\Models\User;
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
        'App\Models\SchoolClass' => 'App\Policies\SchoolClassPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define the 'manage subject assignments' gate
        Gate::define('manage subject assignments', function (User $user) {
            // Only users with admin role can manage subject assignments
            return $user->hasRole('admin');
        });

        // Define the 'view subject assignments' gate
        Gate::define('view subject assignments', function (User $user) {
            // Teachers and above can view subject assignments
            return $user->hasAnyRole(['admin', 'teacher']);
        });
    }
}

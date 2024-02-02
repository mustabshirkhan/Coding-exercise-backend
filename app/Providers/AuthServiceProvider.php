<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        \App\Models\Transaction::class => \App\Policies\TransactionPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {

//        Gate::define('isAdmin', function (User $user) {
//            return true;
//        });
//
//        Gate::define('isCustomer', function (User $user) {
//            return $user->role == 'customer' ? 1 : 0;
//        });
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->role == 'admin';
        });
        Passport::tokensExpireIn(now()->addDays(7));
        Passport::refreshTokensExpireIn(now()->addDays(30));

    }
}

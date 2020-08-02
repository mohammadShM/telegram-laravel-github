<?php

namespace App\Providers;

use App\Chat;
use App\Contact;
use App\Policies\ChatPolicy;
use App\Policies\ContactPolicy;
use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Contact::class => ContactPolicy::class,
        User::class => UserPolicy::class,
        Chat::class => ChatPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGates();
        // for passport
        //Passport::routes();
    }

    private function registerGates()
    {
        Gate::define('change-setting', function ($user) {
            /** @var User $user */
            return !$user->trashed();
        });
    }
}

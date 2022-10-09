<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Animal;
use App\Policies\AnimalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected $policies = [
        Animal::class => AnimalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}

<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Models;
use App\Models\Order;
use App\Policies\ModelPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
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
        Order::class => OrderPolicy::class,
        Models::class => ModelPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('create-order', [OrderPolicy::class,'create']);
        Gate::define('view-order', [OrderPolicy::class,'view']);
        Gate::define('update-order', [OrderPolicy::class,'update']);
        Gate::define('delete-order', [OrderPolicy::class,'delete']);

        Gate::define('create-product', [ProductPolicy::class,'create']);
        Gate::define('view-product', [ProductPolicy::class,'view']);
        Gate::define('update-product', [ProductPolicy::class,'update']);
        Gate::define('delete-product', [ProductPolicy::class,'delete']);

        Gate::define('create-model', [ModelPolicy::class,'create']);
        Gate::define('view-model', [ModelPolicy::class,'view']);
        Gate::define('update-model', [ModelPolicy::class,'update']);
        Gate::define('delete-model', [ModelPolicy::class,'delete']);
    }
}

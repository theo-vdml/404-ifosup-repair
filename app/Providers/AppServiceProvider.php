<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Ticket;
use App\Models\TicketUser;
use App\Models\User;
use App\Observers\TicketObserver;
use App\Observers\TicketUserObserver;
use App\Policies\CustomerPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Ticket::observe(TicketObserver::class);
        TicketUser::observe(TicketUserObserver::class);

        // Register policies
        Gate::policy(Customer::class, CustomerPolicy::class);
        Gate::policy(Ticket::class, TicketPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}

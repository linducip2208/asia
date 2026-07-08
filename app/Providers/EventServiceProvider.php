<?php

namespace App\Providers;

use App\Events\OrderCompleted;
use App\Listeners\CreateOrderJournalEntry;
use App\Listeners\UpdateLoyaltyAndStock;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCompleted::class => [
            CreateOrderJournalEntry::class,
            UpdateLoyaltyAndStock::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}

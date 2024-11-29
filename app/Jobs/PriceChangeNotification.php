<?php

namespace App\Jobs;

use App\Models\Advert;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\PriceChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class PriceChangeNotification implements ShouldQueue
{
    use Queueable;

    protected Advert $advert;

    /**
     * Create a new job instance.
     */
    public function __construct($advert)
    {
        $this->advert = $advert;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach (User::whereIn('id', Subscription::getSubscribersIdsByAdvertId($this->advert->id))->get() as $user) {
            $user->notify(new PriceChanged($this->advert));
        }
    }
}

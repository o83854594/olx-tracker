<?php

namespace App\Services;

use App\Models\Advert;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionService
{
    public function subscribe($email, $url, $sku, $price)
    {
        $user = User::firstOrCreate(['email' => $email]);
        $advert = Advert::firstOrCreate(['sku' => $sku], ['previous_price' => $price, 'price' => $price, 'url' => $url]);
        $subscription = Subscription::firstOrCreate(['user_id' => $user->id, 'advert_id' => $advert->id]);

    }
}

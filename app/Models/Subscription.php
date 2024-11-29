<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];

    public static function getSubscribersIdsByAdvertId($advertId)
    {
        return array_column(
            Subscription::where('advert_id', '=', $advertId)->get('user_id')->toArray(),
            'user_id'
        );
    }
}

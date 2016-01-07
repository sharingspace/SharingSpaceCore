<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'stripe_subscriptions';
    protected $errors;

    public function user(){
        return $this->belongsTo( '\App\Models\User','billable_id', 'id');
    }

}

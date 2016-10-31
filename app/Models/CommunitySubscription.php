<?php
/**
 * This model handles relationships related to Community Subscriptions for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class CommunitySubscription extends Model
{
    protected $table = 'stripe_subscriptions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['stripe_id'];

    protected $errors;

    protected $dates = [
        'period_starts_at', 
        'period_ends_at', 
        'ended_at',
        'canceled_at',
        'trial_starts_at',
        'trial_ends_at',
    ];

    protected $casts = [
        'active' => 'boolean'
    ];

    /**
    * Returns the subscription information for a user.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function user()
    {
        return $this->belongsTo('\App\User', 'billable_id', 'id');
    }

    /**
    * Returns the subscription information for a community.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return collection
    */
    public function community()
    {
        return $this->hasOne('\App\Community', 'id', 'community_id');
    }
}

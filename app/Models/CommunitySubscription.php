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

    public function user()
    {
        return $this->belongsTo('\App\Models\User', 'billable_id', 'id');
    }

    public function community()
    {
        return $this->hasOne('\App\Community', 'id', 'community_id');
    }

}

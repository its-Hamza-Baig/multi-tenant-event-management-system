<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'event_limit',
        'attendee_limit',
        'seat_maps',
        'discount_codes',
    ];

    public function subscriptions()
    {
        return $this->hasMany(TenantSubscription::class, 'plan_id');
    }
}

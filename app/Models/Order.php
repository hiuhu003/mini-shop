<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'pickup_station_id',
        'status',
        'payment_method',
        'mpesa_phone',
        'card_last4',
        'items_count',
        'subtotal',
        'delivery_fee',
        'total'
    ];

    public const STATUS_MAP = [
        'pending'               => 'Pending',
        'in_progress'           => 'In progress',
        'delivered_at_station'  => 'Delivered at station',
        'picked_up'             => 'Picked up',
        'cancelled'  => 'Cancelled',
    ];

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_MAP[$this->status] ?? ucfirst(str_replace('_',' ',$this->status));
    }
    
    public function items()  {
        return $this->hasMany(OrderItem::class);
    }

    public function user()   {
        return $this->belongsTo(User::class); 
    }

    public function station(){ 
        return $this->belongsTo(PickupStation::class,'pickup_station_id'); 
    }

    
}

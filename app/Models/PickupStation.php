<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupStation extends Model
{
    protected $fillable = ['name','address','city','notes','is_active'];
    public function scopeActive($q){ return $q->where('is_active', true); }
}

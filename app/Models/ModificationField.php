<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificationField extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id', 
        'field_name', 
        'field_code', 
        'description', 
        'base_price', 
        'is_active'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function prices()
    {
        return $this->hasMany(ServicePrice::class);
    }

    public function getPriceForUserType($userType)
    {
        return $this->prices()
            ->where('user_type', $userType)
            ->value('price') ?? $this->base_price;
    }
}
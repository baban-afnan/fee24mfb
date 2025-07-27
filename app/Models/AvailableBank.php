<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableBank extends Model
{
    protected $table = 'available_banks'; // your actual DB table name

    protected $fillable = [
        'bank_name'
    ];

    public $timestamps = false; 
}

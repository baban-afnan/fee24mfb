<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model


{
    protected $table = 'transactions'; 
    
    protected $fillable = [
        'transaction_ref', 'user_id', 'amount', 'description',
        'type', 'status', 'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NinValidation extends Model
{
    protected $table = 'nin_validation';

    protected $fillable = [
        'reference',
        'user_id',
        'service_id',
        'service_name', 
        'modification_field_id',
        'modification_field_name',
        'nin',
        'transaction_id',
        'submission_date',
        'status',
        'comment'
    ];

    protected $casts = [
        'submission_date' => 'datetime',
    ];

    // Relationships
    public function modificationField()
    {
        return $this->belongsTo(ModificationField::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
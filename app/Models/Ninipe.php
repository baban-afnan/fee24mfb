<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ninipe extends Model
{
    protected $table = 'nin_ipe';

    protected $fillable = [
        'reference',
        'user_id',
        'modification_field_id',
        'service_id',
        'tracking_id',
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
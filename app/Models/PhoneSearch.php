<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneSearch extends Model
{
    protected $table = 'bvn_search';

   protected $fillable = [
    'reference',
    'user_id',
    'modification_field_id',
    'service_id',
    'number',
    'bvn',
    'first_name',
    'last_name',
    'middle_name',
    'gender',
    'dob',
    'email',
    'lga',
    'state',
    'status',
    'comment',
    'transaction_id',
    'submission_date',
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
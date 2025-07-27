<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CRMSubmission extends Model
{
    protected $table = 'bvn_crm'; 

    protected $fillable = [
        'reference',
        'user_id',
        'modification_field_id',
        'service_id',
        'batch_id',
        'ticket_id',
        'transaction_id',
        'submission_date',
        'status',
        'comment'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function modificationField()
    {
        return $this->belongsTo(ModificationField::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

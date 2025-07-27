<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendVnin extends Model
{
    protected $table = 'send_vnin'; 

    protected $fillable = [
        'reference',
        'user_id',
        'modification_field_id',
        'service_id',
        'request_id',
        'bvn',
        'nin',
        'field',
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

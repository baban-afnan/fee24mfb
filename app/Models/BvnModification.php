<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BvnModification extends Model
{
    protected $table = 'bvn_modification';

   protected $fillable = [
    'reference',
    'user_id',
    'modification_field_id',
    'service_id',
    'bvn',
    'nin',
    'description',
    'affidavit',
    'affidavit_file',
    'affidavit_file_url', 
    'transaction_id',
    'submission_date',
    'status',
    'comment',
    'performed_by',
];


    // If your table includes `created_at` and `updated_at`, leave timestamps enabled
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modificationField()
    {
        return $this->belongsTo(ModificationField::class, 'modification_field_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}

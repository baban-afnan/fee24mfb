<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ninverification extends Model
{
    protected $table = 'nin_verifications';

   protected $fillable = [
    'reference',
    'user_id',
    'modification_field_id',
    'service_id',
    'firstname',
    'middlename',
    'surname',
    'gender',
    'birthdate',
    'birthstate',
    'birthlga',
    'birthcountry',
    'maritalstatus',
    'email',
    'telephoneno',
    'residence_address',
    'residence_state',
    'residence_lga',
    'residence_town',
    'religion',
    'employmentstatus',
    'educationallevel',
    'profession',
    'heigth',
    'title',
    'nin',
    'number_nin', 
    'vnin',
    'photo_path',
    'signature_path',
    'trackingId',
    'userid',
    'nok_firstname',
    'nok_middlename',
    'nok_surname',
    'nok_address1',
    'nok_address2',
    'nok_lga',
    'nok_state',
    'nok_town',
    'nok_postalcode',
    'self_origin_state',
    'self_origin_lga',
    'self_origin_place',
    'transaction_id',
    'submission_date',
    'status',
    'created_at',
    'updated_at',
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
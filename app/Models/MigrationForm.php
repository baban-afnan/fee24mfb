<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MigrationForm extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'business_name',
    'business_address',
    'business_email',
    'state',
    'lga',
    'address',
    'nearest_bustop',
    'office_image',
    'nepa_bill',
    'cac_upload',
    'reference',
    'status',
];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEnrollment extends Model
{
    protected $table = 'user_enrollments';

    protected $fillable = [
        'agent_code',
        'agent_name',
        'enroller_code',
        'ticket_number',
        'bvn',
        'bms_import_id',
        'validation_status',
        'validation_message'
    ];
}

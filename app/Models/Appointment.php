<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'passport_no',
        'phone_no',
        'email',
        'appt_date',
        'appt_time',
        'reason',
        'status',
    ];
}

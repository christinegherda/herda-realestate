<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'description',
        'address',
        'broker_coordinator_name',
        'broker_coordinator_fb',
        'contact_number',
    ];
}

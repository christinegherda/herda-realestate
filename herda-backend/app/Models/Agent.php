<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['name', 'position', 'email', 'contact_number', 'viber', 'whatsapp', 'photo'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

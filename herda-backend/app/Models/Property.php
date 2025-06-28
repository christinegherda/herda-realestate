<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'agent_id',
        'name',
        'slug',
        'price',
        'description',
        'location',
        'bedrooms',
        'bathrooms',
        'floor_area',
        'lot_area',
        'property_type',
        'status',
        'gdrive_link',
        'thumbnail',
        'gallery',
        'latitude',
        'longitude',
        'developer',
        'featured',
        'city',
        'address',
        'model_type',
        'lot_plan',
        'title_document',
        'tax_declaration',
        'atn_ats',
    ];

    protected $casts = [
        'gallery' => 'array',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_property',
        'description',
        'image',
    ];

    // Relasi ke property_types
    public function propertyTypes()
    {
        return $this->hasMany(PropertyType::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyTypeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_type_id',
        'image_path',
        'order_no',
    ];

    // Relasi ke property type
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
}

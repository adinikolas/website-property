<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PropertyType extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'name_type',
        'jenis_type',
        'jml_kamar',
        'harga_jual',
        'kpr',
        'dp',
        'booking',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    // Relasi ke property
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Relasi ke gambar type
    public function images()
    {
        return $this->hasMany(PropertyTypeImage::class)
            ->orderBy('order_no', 'asc');
    }

    // Ambil gambar utama
    public function primaryImage()
    {
        return $this->hasOne(PropertyTypeImage::class)
            ->orderBy('order_no', 'asc');
    }
}

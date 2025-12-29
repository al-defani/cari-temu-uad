<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Pastikan semua kolom ini terdaftar di $fillable
    protected $fillable = [
        'nama_barang',
        'category_id',
        'deskripsi',
        'lokasi',
        'jenis',
        'status', // Ini sering terlupa
        'user_id',
        'foto',
        'telepon',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bien_the_san_pham extends Model
{
    use HasFactory;

    protected $fillable = [
        'san_pham_id',
        'size_san_pham_id',
        'color_san_pham_id',
        'so_luong',
        'gia',
        'anh_bien_the'
    ];

    public function san_pham()
    {
        return $this->belongsTo(san_pham::class);
    }

    public function size()
    {
        return $this->belongsTo(size_san_pham::class, 'size_san_pham_id');
    }

    public function color()
    {
        return $this->belongsTo(color_san_pham::class, 'color_san_pham_id');
    }
}
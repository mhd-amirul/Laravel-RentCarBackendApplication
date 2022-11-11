<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class car extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'cars';
    protected $fillable = [
        "shop_id",
        "slug",
        "plat",
        "brand",
        "model",
        "varian",
        "transmisi",
        "tahun",
        "warna",
        "cc",
        "seater",
        "bbm",
        "harga", "image1", "image2", "image3"
    ];

}

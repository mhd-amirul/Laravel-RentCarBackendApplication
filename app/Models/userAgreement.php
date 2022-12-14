<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class userAgreement extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'user_agreements';
    protected $fillable = [
        "user_id",
        "store_id",
        "status",
        "description"
    ];
}

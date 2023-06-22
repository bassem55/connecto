<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend extends Model
{
    use HasFactory;
    protected $table = "friends";
    protected $filleable = ["friend_id_1" , "friend_id_2"];
    protected $hidden = [];
    public $timestamps = true;
}

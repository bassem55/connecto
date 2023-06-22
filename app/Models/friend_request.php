<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class friend_request extends Model
{
    use HasFactory;
    protected $table="friend_requests";
    protected $fillable = ["sent_id" , "recive_id"];
    protected $hidden = [];
    public $timestamps = true;
}

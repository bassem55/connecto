<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chat extends Model
{
    use HasFactory;
    protected $table="chats";
    protected $fillable = ["from_id" , "msg" , "to_id"];
    protected $hidden = [];
    public $timestamps = true;
}

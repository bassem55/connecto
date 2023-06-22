<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $filleable = ["notification" , "to_id"];
    protected $hidden = [];
    public $timestamps = true;
}

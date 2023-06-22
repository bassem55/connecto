<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class react extends Model
{
    use HasFactory;

    protected $table="reacts";
    protected $fillable = [ "id" ,"post_id" , "react_owner_id"];
    protected $hidden = [];
    public $timestamps = true;
}

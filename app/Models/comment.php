<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;
    protected $table="comments";
    protected $fillable = ["id" , "comment" , "post_id" ,"user_id"];
    protected $hiidden = [];
    public $timestamps = true;

    public function post()
    {
        return $this->belongsTo('App\Models\post' , 'post_id' , 'id');
    }
    public function comment_writer()
    {
        return $this->belongsTo('App\Models\User' , 'user_id' , 'id');
    }

}


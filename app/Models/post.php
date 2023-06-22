<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    protected $table="posts";
    protected $fillable = [ "id" ,"post" , "user_id"];
    protected $hidden = [];
    public $timestamps = true;

    public function writer()
    {
        return $this->belongsTo('App\Models\User' , 'user_id' , 'id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\comment' , 'post_id' , 'id');
    }
    public function reacts()
    {
        return $this->hasMany('App\Models\react' , 'post_id' , 'id');
    }
}

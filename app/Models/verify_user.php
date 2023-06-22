<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class verify_user extends Model
{
    use HasFactory;
    protected $table= "verify_users";
    protected $fillable = ["user_id","token"];
    protected $hidden   = [];
    public $timestamps = true;

    /*
    public function user()
    {
        return $this->beLongsTo('App\Models\User' , 'user_id');
    }

    */
}

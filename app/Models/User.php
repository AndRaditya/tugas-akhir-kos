<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $dates = ['created_at', 'updated_at'];
    protected $hidden = array('password');
    protected $guarded = ["id"];
    

    public function user_role()
    {
        return $this->hasOne(UsersRole::class,'user_id','id');
    }
    
    
}
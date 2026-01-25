<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emailsetting extends Model
{
    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }
    public function users()
    {
        return $this->hasManyThrough(User::class,Role::class,'id','role_id','role_id','id');
    }
}

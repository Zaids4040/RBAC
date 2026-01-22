<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    public function package()
    {
        return $this->belongsTo(Package::class,'package_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}

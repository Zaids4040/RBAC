<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function lead()
    {
        return $this->hasMany(Lead::class,'package_id','id');
    }
}

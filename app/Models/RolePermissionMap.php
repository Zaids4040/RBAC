<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermissionMap extends Model
{
    public function permissionrelation()
    {
       return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}

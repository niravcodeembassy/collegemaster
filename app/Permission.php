<?php

namespace App;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    //
    public function childs() {
        return $this->hasMany(Permission::class,'parent_id','id') ;
    }

}

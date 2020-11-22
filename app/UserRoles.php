<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    protected $table = 'user_roles';

    public function users(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function roles(){
    	return $this->belongsTo('App\Roles', 'id_role','id');
    }

}

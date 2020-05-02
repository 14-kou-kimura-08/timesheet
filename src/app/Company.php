<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * Get the users.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the plans.
     */
    public function plans()
    {
        return $this->hasMany('App\Plan');
    }
}

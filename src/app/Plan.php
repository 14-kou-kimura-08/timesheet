<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_plans';

    /**
     * The users that belong to the plan.
     */
    public function users()
    {
        return $this->belongsToMany('App\User', 'plan_user');
    }
}

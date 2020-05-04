<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plan_id', 'user_id', 'date'
    ];

    /**
     * Get the user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the plan.
     */
    public function plan()
    {
        return $this->belongsTo('App\Plan');
    }
}

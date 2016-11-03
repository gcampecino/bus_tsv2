<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $table = 'bus';
    public $timestamps = true;

    /**
     * Get the schedules
     */
    public function schedules()
    {
        return $this->hasMany('App\Models\BusStopSchedule', 'bus_id', 'id');
    }
}

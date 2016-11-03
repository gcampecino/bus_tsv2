<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusStop extends Model
{
    //
    protected $table = 'bus_stop';
    public $timestamps = true;


    /**
     * Get the schedules.
     */
    public function buStopSchedule()
    {
        return $this->hasMany('App\Models\BusStopSchedule', 'bus_stop_id', 'id');
    }

}

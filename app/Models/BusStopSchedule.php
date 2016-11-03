<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusStopSchedule extends Model
{
    //
    protected $table = 'bus_stop_schedule';
    public $timestamps = true;

    /**
     * Get the bus stop.
     */
    public function busStop()
    {
        return $this->belongsTo('App\Models\BusStop');
    }

    /**
     * Get the bus.
     */
    public function bus()
    {
        return $this->belongsTo('App\Models\Bus');
    }
}

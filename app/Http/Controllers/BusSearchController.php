<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusStop;
use App\Models\BusStopSchedule;
use DB;
use Gate;

class BusSearchController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return [
	 * 		[id => 1,
	 * 		name => 'Statoin 1',
	 * 		description => 'Desc',
	 * 		distanceFromUser => 11.30012,
	 *		buses => [
				[day => 'Sunday',
					time => '08:00',
					name => 'Cisra',
					bus_desc => 'Blue bus',
					sched_desc => 'Notice desc'],
				[day => 'Sunday',
					time => '08:00',
					name => 'Cisra',
					bus_desc => 'Blue bus',
					sched_desc => 'Notice desc']
			]
	 * ]]
     */
    public function index()
    {
		//check authorization
        if(Gate::denies('bus-search'))
            return redirect('/bus');

        //user location
        $latitude = 1.299430;
        $longitude = 103.855669;

        //get all bus stops
        $busStops = BusStop::select('id',
                        'name',
                        'description',
                        DB::raw('(6371 * acos(cos(radians(latitude)) * cos( radians('.$latitude.')) * cos( radians('.$longitude.') - radians(longitude)) + sin(radians(latitude)) * sin( radians('.$latitude.')))) AS distanceFromUser'))
                    ->orderBy('distanceFromUser', 'asc')
                    ->get();

        //map busses scheduled in the bus stop
        $schedules = [];
        foreach ($busStops as $busStop) {
            $bstop = [
                'id' => $busStop->id,
                'name' => $busStop->name,
                'description' => $busStop->description,
                'distanceFromUser' => $busStop->distanceFromUser
            ];

			//get all bus assigned to the bus stop
            $busStopScheds = DB::table('bus_stop_schedule')
                ->leftJoin('bus', 'bus.id', '=', 'bus_stop_schedule.bus_id')
                ->select(
                        'bus_stop_schedule.day',
                        'bus_stop_schedule.time',
                        'bus_stop_schedule.description as sched_desc',
                        'bus.name',
                        'bus.description as bus_desc'
                        )
                ->where('bus_stop_id', $busStop->id)
                ->orderByRaw(DB::raw("FIELD(bus_stop_schedule.day, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY'), `bus_stop_schedule`.`time` asc"))
                ->get();

            $buses = [];
            foreach ($busStopScheds as $busStopSched) {
                $buses[] = [
                    'day' => $busStopSched->day,
                    'time' => $busStopSched->time,
                    'name' => $busStopSched->name,
                    'bus_desc' => $busStopSched->bus_desc,
                    'sched_desc' => $busStopSched->sched_desc
                ];
            }

            $bstop['buses'] = $buses;
            $schedules[] = $bstop;
        }

        return view('bus.search', ['schedules' => $schedules]);
    }
}

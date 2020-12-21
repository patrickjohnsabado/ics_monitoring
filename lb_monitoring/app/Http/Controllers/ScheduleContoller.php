<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\account_information;
use App\Subject;
use App\Schedule;
use App\Setting;
use App\Room;
use DB;
use Carbon\Carbon;

class ScheduleContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = DB::table('schedules')
                        ->join('subjects','subjects.id','=','schedules.subject_id')
                        ->join('rooms','rooms.id','=','schedules.room_id')
                        ->join('school_year','school_year.id','=','schedules.sy_id')
                        ->join('account_information','account_information.id_number','=','schedules.faculty_id')
                        ->join('users','users.id_number','=','account_information.id_number')
                        ->where('school_year.current','=','1')
                        ->select('subjects.course_number', 'subjects.unit', 'subjects.description','schedules.*','account_information.id_number','account_information.fullname','rooms.room_number', 'rooms.room_type','schedules.id as sched_id')
                        ->get();
        $faculties = account_information::where('type','=','Faculty')->get();
        $subjects = Subject::all();
        $rooms = Room::all();

        return view('schedules.index', compact('schedules','faculties','subjects','rooms'))->with('no', 1);

    }

    public function histindex()
    {
        $schedules_hist = DB::table('history_schedules')
                        ->join('subjects','subjects.id','=','history_schedules.subject_id')
                        ->join('rooms','rooms.id','=','history_schedules.room_id')
                        ->join('history_school_year','history_school_year.id','=','history_schedules.sy_id')
                        ->join('history_account_information','history_account_information.id_number','=','history_schedules.faculty_id')
                        ->join('history_users','history_users.id_number','=','history_account_information.id_number')
                        ->select('subjects.course_number', 'subjects.unit', 'subjects.description','history_schedules.*','history_account_information.id_number','history_account_information.fullname','rooms.room_number', 'rooms.room_type','history_schedules.id as sched_id')
                        ->get();
        $schedules = DB::table('history_schedules')
                        ->join('subjects','subjects.id','=','history_schedules.subject_id')
                        ->join('rooms','rooms.id','=','history_schedules.room_id')
                        ->join('history_school_year','history_school_year.id','=','history_schedules.sy_id')
                        ->join('account_information','account_information.id_number','=','history_schedules.faculty_id')
                        ->join('users','users.id_number','=','account_information.id_number')
                        ->select('subjects.course_number', 'subjects.unit', 'subjects.description','history_schedules.*','account_information.id_number','account_information.fullname','rooms.room_number', 'rooms.room_type','history_schedules.id as sched_id')
                        ->get();                        
        $faculties = account_information::where('type','=','Faculty')->get();
        $subjects = Subject::all();
        $rooms = Room::all();

        return view('schedules.histindex', compact('schedules','faculties','subjects','rooms','schedules_hist'))->with('no', 1);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $time = Carbon::create($request->input('from_time'))->format('H');
        $time2 = Carbon::create($request->input('to_time'))->format('H');
        $time_min = Carbon::create($request->input('from_time'))->format('i');
        $time_min_2 = Carbon::create($request->input('to_time'))->format('i');
        
        $time3 = $time2 - $time;
        $time_min_3 = $time_min_2 - $time_min;
        if (count($request->input('days')) > '2')
        {
            return back()->withInput()->with('error', 'Lab subjects are maximum of 2 days per week');
            //return 'subjects that are schedule for 3 meetings a week must be 1 hour per meeting';
        }
        if($request->input('days') == NULL)
        {
            return back()->withInput()->with('error', 'No day/s of the Week Selected');
            //return 'no scheduled day of the selected';
        }

        if ($time3 != '2' && $time_min_3 != '30' && count($request->input('days')) == '2')
        {
            
            return back()->withInput()->with('error', 'Subjects that are scheduled 2 times a week should be 1 hours and 30 minutes per meeting');
            //return 'subjects that are schedule for 2 meetings a week must be 1 hour and 30 minutes per meeting';
        }

        if ($time3 != '3' && $time_min_3 != '0' && count($request->input('days')) == '1')
        {
            
            return back()->withInput()->with('error', 'Subjects that are scheduled 2 times a week should be 1 hours and 30 minutes per meeting');
            //return 'subjects that are schedule for 2 meetings a week must be 1 hour and 30 minutes per meeting';
        }

        if($time3 < 1)
        {
            
            return back()->withInput()->with('error', 'Start time should not be ahead of End time');
        }
        
    //$setting = Setting::where('current','=','1')->first();

        if (Schedule::where('code', '=', $request->input('code'))->where('sy_id','=',Setting::where('current','=',1)->first()->id)->exists())
        {
            return back()->withInput()->with('error', 'This Schedule already exist in the Current Semester');
        }

        $time_err = Carbon::create($request->input('from_time'))->format('H:i:s');
        $time_err_2 = Carbon::create($request->input('to_time'))->format('H:i:s');
        $day_err = $request->input('days');
        for ($i=0; $i < count($request->input('days')); $i++) { 
            $reservations_err1 = DB::table('schedules')
                ->join('rooms','rooms.id','=','schedules.room_id') 
                ->where('day_of_the_week','like','%'.$day_err[$i].'%')
                ->where('schedules.room_id',$request->input('room'))
                ->where('sy_id','=',Setting::where('current','=',1)->first()->id)
                ->where(function($query) use ($time_err,$time_err_2){
                    $query->orwhere('hour_start','>=',$time_err)
                          ->orwhere('hour_end','>=',$time_err_2);
                })
                ->select('rooms.room_number')
                ->get();
                
                $reservations_err2 = DB::table('schedules')
                        ->join('rooms','rooms.id','=','schedules.room_id') 
                        ->where('day_of_the_week','like','%'.$day_err[$i].'%')
                        ->where('schedules.room_id',$request->input('room'))
                        ->where('sy_id','=',Setting::where('current','=',1)->first()->id)
                        ->where(function($query) use ($time_err,$time_err_2){
                            $query->where('hour_start','<',$time_err)
                                ->Where('hour_end','<',$time_err_2);
                        })
                        ->select('rooms.room_number')
                        ->get();
                //return $time.' - '.$time2;
                //return $reservations_err1;
                if ($reservations_err1->count() > 0) {
                    if ($day_err[$i] == 1){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Monday');
                    }
                    if ($day_err[$i] == 2){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Tuesday');
                    }
                    if ($day_err[$i] == 3){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Wednesday');
                    }
                    if ($day_err[$i] == 4){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Thursday');
                    }
                    if ($day_err[$i] == 5){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Friday');
                    }
                    if ($day_err[$i] == 6){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Saturday');
                    }
                }

                if ($reservations_err2->count() > 0) {
                    if ($day_err[$i] == 1){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Monday');
                    }
                    if ($day_err[$i] == 2){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Tuesday');
                    }
                    if ($day_err[$i] == 3){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Wednesday');
                    }
                    if ($day_err[$i] == 4){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Thursday');
                    }
                    if ($day_err[$i] == 5){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Friday');
                    }
                    if ($day_err[$i] == 6){
                        return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err2->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on day Saturday');
                    }
                }
        }
        /*$reservations_err1 = DB::table('reservations')
                ->join('rooms','rooms.id','=','reservations.room_id') 
                ->where('day_of_the_week','like',$dt)
                ->where('reservations.room_id',$request->input('room'))
                ->where(function($query) use ($time_err,$time_err_2){
                    $query->orwhere('start','>=',$time_err)
                          ->orwhere('end','>=',$time_err_2);
                })
                ->select('rooms.room_number')
                ->get();
        
        $reservations_err2 = DB::table('reservations')
                ->join('rooms','rooms.id','=','reservations.room_id') 
                ->where('date','=',$dt)
                ->where('reservations.room_id',$request->input('room'))
                ->where(function($query) use ($time_err,$time_err_2){
                    $query->where('start','<',$time_err)
                          ->Where('end','<',$time_err_2);
                })
                ->select('rooms.room_number')
                ->get();
        //return $time.' - '.$time2;
        //return $reservations_err1;
        if ($reservations_err1->count() > 0) {
            return back()->with('error', 'Error, There is a room and schedule conflict with room '.$reservations_err1->implode('room_number', ', ').', Schedule '.$time_err.' - '.$time_err_2.' on date '.$dt.'.');
        }

        if ($reservations_err2->count() > 0) {
            return back()->with('error', 'Error, There is a room conflict with room '.$reservations_err2->implode('room_number', ', ').', Room/s selected is already full with the time selected, '.$time.' - '.$time2.' on date '.$dt.'.');
        }
        */
        $days = implode(",", $request->input('days'));
        $schedule = new Schedule;
        $schedule->hour_start =  $request->input('from_time');
        $schedule->hour_end =  $request->input('to_time');
        $schedule->day_of_the_week =  $days;
        $schedule->code = $request->input('code');
        $schedule->room_id =  $request->input('room');
        $schedule->faculty_id =  $request->input('faculty');
        $schedule->sy_id =  Setting::where('current','=',1)->first()->id;
        $schedule->subject_id =  $request->input('subject');
        $schedule->save();
        return back()->with('success', 'Successfuly added a new Schedule');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deleteAll(Request $request)
    {
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            if(\Auth::check()){
                    if($request->delete != NULL) {
                        $delete = $request->delete;
                        
                        if ($request->input('archive') == '1') {
                            DB::table("history_schedules")->whereIn('id', $delete)->delete();
                            return back()->with('success', 'Delete of Schedule/s is Successful');
                        }
                        DB::table("schedules")->whereIn('id', $delete)->delete();
                        return back()->with('success', 'Delete of Schedule/s is Successful');
                    }
                        return back();
            }
            return redirect('/login');
        }
    }
}

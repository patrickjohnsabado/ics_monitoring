<?php

namespace App\Http\Controllers;
use App\Room;
use App\Borrower;
use App\Setting;
use App\Logs;
use App\Schedule;
use DB;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $rooms = Room::all();
            return view('rooms.index', compact('rooms'));
        }
    }


    public function openLab()
    {
        if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $rooms = DB::table('rooms')
                       ->join('login_logs','login_logs.room_id','=','rooms.id')
                       ->where('rooms.room_type','=','Open Lab')
                       ->select(DB::raw('DATE(date_login) AS date_login'),'room_number',DB::raw('count(login_logs.id) as count'),'rooms.room_type')
                       ->groupBy('date_login', 'room_number')
                       ->get();
        return view('rooms.openlab', compact('rooms'));
        }
        $title = 'No Sufficient Access';
        $body = 'Only Super Admin can Access this Page';
        return view('error', compact('title','body'));
    }

    public function lab()
    {
        if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $rooms = DB::table('rooms')
                       ->join('login_logs','login_logs.room_id','=','rooms.id')
                       ->where('rooms.room_type','=','Lab')
                       ->select(DB::raw('DATE(date_login) AS date_login'),'room_number',DB::raw('count(login_logs.id) as count'),'rooms.room_type')
                       ->groupBy('date_login', 'room_number')
                       ->get();
            $sem = Setting::where('current','=',1)->first();
            $schedules = DB::table('schedules')
                           ->join('subjects','subjects.id','=','schedules.subject_id')
                           ->join('rooms','rooms.id','=','schedules.room_id')
                           ->where('sy_id','=',$sem->id)
                           ->get();
            $room_list = Room::all();    

            $monday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%1%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();

            $tuesday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%2%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();
            $wednesday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%3%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();
            $thursday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%4%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();
            $friday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%5%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();  
            $saturday = DB::table('schedules')
                            ->join('rooms','rooms.id','=','schedules.room_id')
                            ->where('day_of_the_week', 'like', '%6%')
                            ->where('sy_id','=',$sem->id)
                            ->select('room_number',DB::raw('SUM(TIME_TO_SEC(SUBTIME(hour_end, hour_start))) num_of_hours'))
                            ->groupBy('room_number')
                            ->get();
            $open_hours = 9;
            return view('rooms.lab', compact('rooms','sem','room_list','monday','tuesday','wednesday','thursday','friday','saturday','open_hours'));
        }
        $title = 'No Sufficient Access';
        $body = 'Only Super Admin can Access this Page';
        return view('error', compact('title','body'));
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
        if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            if (Room::where('room_number','=',$request->input('room_number'))->count() > 0) {
                return back()->with('error', 'There is already a room created with this Room Number, '.$request->input('room_number'));
            }

            $room = new Room;
            $room->room_number = $request->input('room_number');
            $room->room_type = $request->input('room_type');
            $room->save();
            return back()->with('success', 'Successfully added Room '.$request->input('room_number').' '.$request->input('room_type'));
        }
        $title = 'No Sufficient Access';
        $body = 'Only Super Admin can Access this Page';
        return view('error', compact('title','body'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $room_detail = Room::where('room_number','=',$id)->first();
        
        $schedules = DB::table('schedules')
                        ->join('subjects','subjects.id','=','schedules.subject_id')
                        ->join('rooms','rooms.id','=','schedules.room_id')
                        ->join('school_year','school_year.id','=','schedules.sy_id')
                        ->join('account_information','account_information.id_number','=','schedules.faculty_id')
                        ->join('users','users.id_number','=','account_information.id_number')
                        ->where('school_year.current','=','1')
                        ->where('room_number','=',$id)
                        ->select('subjects.course_number', 'subjects.unit', 'subjects.description','schedules.*','account_information.id_number','account_information.fullname','rooms.room_number', 'rooms.room_type','schedules.id as sched_id')
                        ->get();
        
        return view('rooms.show', compact('schedules','room_detail'))->with('no', 1);                        
    }

    public function roomShow($room_id,$room_type,$date)
    {
        
        $room_detail = Room::where('room_number','=',$room_id)->where('room_type','=',$room_type)->first();

        $logs = Logs::join('account_information','account_information.id_number','=','login_logs.id_number')
                        ->join('users','users.id_number','=','account_information.id_number')
                        ->join('school_year','login_logs.sy_id','=','school_year.id')
                        ->join('rooms','rooms.id','=','login_logs.room_id')
                        ->join('subjects','subjects.id','=','login_logs.subject_id')
                        ->where('rooms.room_number','=',$room_id)
                        ->where('rooms.room_type','=',$room_type)
                        ->where('school_year.current','=',1)
                        ->select('login_logs.id AS log_id','account_information.*','login_logs.*','users.email','school_year.*','rooms.*','subjects.*')
                        ->get();
                        return view('rooms.show', compact('room_detail','logs'))->with('no', 1);
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
        if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            if(\Auth::check()){
                    if($request->delete != NULL) {
                        $delete = $request->delete;
                        if (DB::table("reservations")->whereIn('room_id', $delete)->count() > 0) {
                            return back()->with('error', 'Unable to delete, There are Reservation records mapped to this room/s');
                        }

                        if (DB::table("login_logs")->whereIn('room_id', $delete)->count() > 0) {
                            return back()->with('error', 'Unable to delete, There are log records mapped to this room/s');
                        }
                        
                        DB::table("rooms")->whereIn('id', $delete)->delete();
                        return back()->with('success', 'Successfuly deleted all selected record');
                    }
                        return back();
            }
            return redirect('/login');
        }
    }
}

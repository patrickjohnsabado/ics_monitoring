<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\account_information;
use App\Logs;
use App\User;
use App\Subject;
use App\Room;
use App\Reservation;
use App\Setting;
use DB;
use Carbon\Carbon;
class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {
            $sy_1 = Carbon::create(Setting::where('current','=',1)->first()->start);
            $sy_2 = Carbon::create(Setting::where('current','=',1)->first()->end);
            $reservations = DB::table('reservations')
                    ->join('users','users.id_number','=','reservations.id_number')
                    ->join('account_information','users.id_number','=','account_information.id_number')
                    ->join('subjects','subjects.id','=','reservations.subject_id')
                    ->join('rooms','rooms.id','=','reservations.room_id')
                    ->whereYear('start', $sy_1->year)
                    ->whereMonth('start', $sy_1->month)
                    ->whereYear('end', $sy_2->year)
                    ->whereMonth('end', $sy_2->month)
                    ->whereDay('start', '>=', $sy_1->day)
                    ->whereDay('end', '<=', $sy_2->day)
                    ->select('account_information.*','users.email','subjects.*','rooms.*','reservations.*','reservations.id as reservation_id','reservations.id_number as r_id_number')
                    ->get();
                    if (account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') {
                        $faculties = account_information::where('type','=','faculty')->get();
                    } else {
                        $faculties = account_information::where('type','=','faculty')->where('id_number','=',auth()->user()->id_number)->get();
                    }
                $subjects = Subject::all();
                $rooms = Room::all();
                //return $reservations;
                return view('reservations.index', compact('reservations','subjects','rooms','faculties'));
        }
    }

    public function calendar()
    {
        $sy_1 = Carbon::create(Setting::where('current','=',1)->first()->start);
        $sy_2 = Carbon::create(Setting::where('current','=',1)->first()->end);
        $reservations = DB::table('reservations')
                ->join('users','users.id_number','=','reservations.id_number')
                ->join('account_information','users.id_number','=','account_information.id_number')
                ->join('subjects','subjects.id','=','reservations.subject_id')
                ->join('rooms','rooms.id','=','reservations.room_id')
                ->whereYear('start', $sy_1->year)
                ->whereMonth('start', $sy_1->month)
                ->whereYear('end', $sy_2->year)
                ->whereMonth('end', $sy_2->month)
                ->whereDay('start', '>=', $sy_1->day)
                ->whereDay('end', '<=', $sy_2->day)
                ->select('account_information.*','users.email','subjects.*','rooms.*','reservations.*')
                ->get();
        $sy_1 = Carbon::create(Setting::where('current','=',1)->first()->start);
        $faculties = account_information::where('type','=','faculty')->get();
        $subjects = Subject::all();
        $rooms = Room::all();
        //return $reservations;
        return view('reservations.calendar', compact('reservations','subjects','rooms','faculties'));
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

        $user = $request->input('user');
        $room = $request->input('room');
        $subject = $request->input('subject');
        //return $user;
        //return Room::whereIn('id',$request->input('room'))->count();
        $dt = Carbon::parse($request->input('date'))->toDateString();
        $time = Carbon::parse($request->input('time_from'))->toTimeString();
        $time2 = Carbon::parse($request->input('time_to'))->toTimeString();
        
        $reservations_err1 = DB::table('reservations')
                ->join('rooms','rooms.id','=','reservations.room_id') 
                ->where('date','=',$dt)
                ->where('reservations.room_id',$request->input('room'))
                ->where(function($query) use ($time,$time2){
                    $query->orwhere('start','>=',$time)
                          ->orwhere('end','>=',$time2);
                })
                ->select('rooms.room_number')
                ->get();
        
        $reservations_err2 = DB::table('reservations')
                ->join('rooms','rooms.id','=','reservations.room_id') 
                ->where('date','=',$dt)
                ->where('reservations.room_id',$request->input('room'))
                ->where(function($query) use ($time,$time2){
                    $query->where('start','<',$time)
                          ->Where('end','<',$time2);
                })
                ->select('rooms.room_number')
                ->get();
        //return $time.' - '.$time2;
        //return $reservations_err1;
        if ($reservations_err1->count() > 0) {
            return back()->with('error', 'Error, There is a room conflict with room '.$reservations_err1->implode('room_number', ', ').', Room/s selected is already full with the time selected, '.$time.' - '.$time2.' on date '.$dt.'.');
        }

        if ($reservations_err2->count() > 0) {
            return back()->with('error', 'Error, There is a room conflict with room '.$reservations_err2->implode('room_number', ', ').', Room/s selected is already full with the time selected, '.$time.' - '.$time2.' on date '.$dt.'.');
        }

        if($time2 < $time || $time == $time2 )
        {
            return back()->withInput()->with('error', 'Ivalid time, Start time cannot be  the same or later with End Time of reservation');
        }
        
            for ($i=0; $i < Subject::whereIn('id',$request->input('subject'))->count(); $i++) { 
                $resesrvation = new Reservation;
                $resesrvation->date = $dt;
                $resesrvation->start = $time;
                $resesrvation->end = $time2;
                $resesrvation->id_number = account_information::where('id_number','=',$user)->first()->id_number;
                $resesrvation->room_id = Room::find($room)->id;
                $resesrvation->subject_id = Subject::find($subject[$i])->id;
                $resesrvation->status = $request->input('status');
                $resesrvation->save();
            
           }
           return back()->with('success', 'Successfully Reserved a Room');

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
        if(\Auth::check()){
                if($request->delete != NULL) {
                    $delete = $request->delete;
                    DB::table("reservations")->whereIn('id', $delete)->delete();
                    return back()->with('success', 'Successfuly deleted all selected record');
                }
                    return back();
        }
        return redirect('/login');
    }
}

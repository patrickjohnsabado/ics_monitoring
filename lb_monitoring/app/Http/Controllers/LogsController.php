<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Logs;
use App\account_information;
use App\Setting;
use App\Room;
use App\School_year;
use App\Subject;
use App\Schedule;
use DB;
use Carbon\Carbon;
use App\Exports\ExportLogs;
use App\Exports\ExportLogsAll;
use App\Exports\ExportLogsToday;
use Maatwebsite\Excel\Facades\Excel;
class LogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty' ) { 
                return redirect('/reservation');
            }
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) { 

                /*$logs = DB::table('login_logs')
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->join('rooms','rooms.id','=','login_logs.room_id')
                            ->join('schedules','schedules.id','=','login_logs.subject_id')
                            ->join('subjects','subjects.id','=','schedules.subject_id')
                            ->select('login_logs.id AS log_id','account_information.*','login_logs.*','users.email','school_year.*','rooms.*','subjects.course_number','subjects.description','schedules.code')
                            ->get();*/
                $logs = DB::table('login_logs')
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->join('rooms','rooms.id','=','login_logs.room_id')
                            ->where('school_year.current','=',1)
                            ->select('login_logs.id AS log_id','account_information.*','login_logs.*','users.email','school_year.*','rooms.*')
                            ->get();
                $subjects = DB::table('schedules')
                                ->join('subjects','schedules.subject_id','=','subjects.id')
                                ->where('schedules.sy_id','=',Setting::where('current','=',1)->first()->id)
                                ->select('subjects.course_number','subjects.description','schedules.*')
                                ->get();
                
                                //return $subjects;
                return view('logs.index', compact('logs','subjects'))->with('no', 1);
            }
            /*
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') { 
                $logs = DB::table('login_logs')
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->where('account_information.type','=','Student')
                            ->join('rooms','rooms.id','=','login_logs.room_id')
                            ->join('subjects','subjects.id','=','login_logs.subject_id')
                            ->select('login_logs.id AS log_id','account_information.*','login_logs.*','users.email','school_year.*','rooms.*','subjects.*')
                            ->get();
                return view('logs.index', compact('logs'))->with('no', 1);
            }
            */
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student') {
                
                $logs = DB::table('login_logs')
                ->join('account_information','account_information.id_number','=','login_logs.id_number')
                ->join('users','users.id_number','=','account_information.id_number')
                ->join('school_year','login_logs.sy_id','=','school_year.id')
                ->where('login_logs.id_number','=',auth()->user()->id_number)
                ->where('account_information.id_number','=',auth()->user()->id_number)
                ->where('school_year.current','=',1)
                ->join('rooms','rooms.id','=','login_logs.room_id')
                ->select('login_logs.id AS log_id','account_information.fullname', 'account_information.type','login_logs.*','users.email', 'login_logs.id_number','school_year.*','rooms.*')
                ->get();
                $subjects = DB::table('subjects')
                                ->join('schedules','schedules.subject_id','=','subjects.id')
                                ->where('schedules.sy_id','=',Setting::where('current','=',1)->first()->id)
                                ->select('subjects.course_number','subjects.description','schedules.*')
                                ->get();
                            
                return view('logs.index', compact('logs','subjects'))->with('no', 1);
            }
        
        }
        return redirect('/login');
    }


    public function histindex()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) { 
                $histlogs = DB::table('history_login_logs')
                            ->join('history_account_information','history_account_information.id_number','=','history_login_logs.id_number')
                            ->join('history_users','history_users.id_number','=','history_account_information.id_number')
                            ->join('school_year','history_login_logs.sy_id','=','school_year.id')
                            ->join('rooms','rooms.id','=','history_login_logs.room_id')
                            ->select('history_login_logs.id AS log_id','history_account_information.*','history_login_logs.*','history_users.email','school_year.*','rooms.*')
                            ->get();
                $logs = DB::table('history_login_logs')
                            ->join('account_information','account_information.id_number','=','history_login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','history_login_logs.sy_id','=','school_year.id')
                            ->join('rooms','rooms.id','=','history_login_logs.room_id')
                            ->select('history_login_logs.id AS log_id','account_information.*','history_login_logs.*','users.email','school_year.*','rooms.*')
                            ->get();            
                return view('logs.histindex', compact('logs','histlogs'))->with('no', 1);
            }
        }
        return redirect('/login');
    }

    function excel(Request $request)
    {
        $dt = Carbon::create($request->input('date'));
        return (new ExportLogs)->forYear($dt->year)->forMonth($dt->month)->forDay($dt->day)->download('logs of '.$dt->month.'-'.$dt->day.'-'.$dt->year.'.xlsx');
    }

    function excelAll()
    {
        return Excel::download(new ExportLogsAll, 'All Logs.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $faculties = account_information::where('type','=','faculty')->get();
        $students = account_information::where('type','=','student')->get();
        $rooms = Room::all();
        $subjects = DB::table('subjects')
                                ->join('schedules','schedules.subject_id','=','subjects.id')
                                ->where('schedules.sy_id','=',Setting::where('current','=',1)->first()->id)
                                ->select('subjects.course_number','subjects.description','schedules.*')
                                ->get();
        return view('logs.create', compact('faculties','students','rooms','subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(\Auth::check()){
    
        $subject = $request->input('subject');
        $dt = Carbon::parse($request->input('date'))->toDateString();
        $time = Carbon::parse($request->input('time_from'))->toTimeString();
        $time2 = Carbon::parse($request->input('time_to'))->toTimeString();
        //  return $dt;
        if($time2 < $time || $time == $time2 )
        {
            return back()->withInput()->with('error', 'Ivalid time, Start time of Login cannot be same/greater with End Time of Login');
        }

        if (account_information::whereIn('id_number',$request->input('user'))->count() > 0) {
            //return $request->input('user');
            for ($i=0; $i < account_information::whereIn('id_number',$request->input('user'))->count(); $i++) { 
                $borrower = account_information::whereIn('id_number',$request->input('user'))->first();
                $log = new Logs;
                $log->id_number = $borrower->id_number;
                $log->subject_id = Schedule::find($subject[$i])->id;;
                $log->date_login = $dt;
                $log->time_from = $request->input('time_from');
                $log->time_to = $request->input('time_to');
                $log->sy_id = School_year::where('current','=','1')->first()->id;
                $log->room_id = Room::where('id','=',$request->input('room'))->first()->id;
                $log->save();
            }
            return back()->with('success', 'Successfuly created a new Log return to List of logs and refresh the page');
        }
        return back()->with('Error', 'No user found');
    }
    return redirect('/login');
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
                    if ($request->input('archive') == '1') {
                        $delete = $request->delete;
                        DB::table("history_login_logs")->whereIn('id', $delete)->delete();
                        return back()->with('success', 'Successfuly deleted all selected record');
                    }
                    
                    $delete = $request->delete;
                    DB::table("login_logs")->whereIn('id', $delete)->delete();
                    return back()->with('success', 'Successfuly deleted all selected record');
                }
                    return back();
        }
        return redirect('/login');
    }
}

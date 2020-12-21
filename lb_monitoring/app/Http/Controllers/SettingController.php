<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\account_information;
use App\Logs;
use App\printing_logs;
use App\Schedule;
use App\history_schedule;
use App\history_school_year;
use App\history_logs;
use App\history_printing_log;
use Carbon\Carbon;

use DB;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') {    
                $settings = Setting::all();
                $setting = Setting::where('current','=','1')->first();
                return view('setting.index', compact('settings','setting'));
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
    }

    public function histindex()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') {    
                $settings = history_school_year::all();
                return view('setting.histindex', compact('settings'));
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') { 
                return view('setting.create');
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
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
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') { 
                $dt = Carbon::parse($request->input('start'))->toDateString();
                $dt2 = Carbon::parse($request->input('end'))->toDateString();
                if($dt > $dt2 || $dt == $dt2)
                {
                    return back()->withInput()->with('error', 'Invalid Dates, Start date of semester cannot be equal or greater than end date of semester');
                }   

                if(Setting::whereBetween('start', array($dt, $dt2))->count() > 0 ||Setting::whereBetween('end', array($dt, $dt2))->count() > 0)
                {
                    /*return Setting::orWhere(function($query) use ($dt,$dt2){
                        $query->orWhere('start','>=',$dt)
                              ->orWhere('end','<=',$dt);
                    })
                    ->orWhere(function($query) use ($dt,$dt2){
                        $query->orWhere('start','>=',$dt)
                              ->orWhere('end','<=',$dt);
                    })->first()->semester;*/
                    return back()
                           ->withInput()
                           ->with('error', 'Invalid Dates, conflict with another semester, '.Setting::orWhere(function($query) use ($dt,$dt2){
                                                                                                            $query->orWhere('start','>=',$dt)
                                                                                                                ->orWhere('end','<=',$dt);
                                                                                                            })
                                                                                                     ->orWhere(function($query) use ($dt,$dt2){
                                                                                                         $query->orWhere('start','>=',$dt)
                                                                                                               ->orWhere('end','<=',$dt);
                                                                                                    })->first()->semester.' Dating from '.Setting::orWhere(function($query) use ($dt,$dt2){
                                                                                                                                                            $query->orWhere('start','>=',$dt)
                                                                                                                                                                  ->orWhere('end','<=',$dt);
                                                                                                                                                            })
                                                                                                                                                    ->orWhere(function($query) use ($dt,$dt2){
                                                                                                                                                        $query->orWhere('start','>=',$dt)
                                                                                                                                                              ->orWhere('end','<=',$dt);
                                                                                                                                                    })->first()->start.' to '.Setting::orWhere(function($query) use ($dt,$dt2){
                                                                                                                                                                                                $query->orWhere('start','>=',$dt)
                                                                                                                                                                                                    ->orWhere('end','<=',$dt);
                                                                                                                                                                                                })
                                                                                                                                                                                        ->orWhere(function($query) use ($dt,$dt2){
                                                                                                                                                                                            $query->orWhere('start','>=',$dt)
                                                                                                                                                                                                ->orWhere('end','<=',$dt);
                                                                                                                                                                                        })->first()->end);
                
                }  
                //return $request;
                $setting = new Setting;
                $setting->semester =  $request->input('semester');
                $setting->start =  $dt;
                $setting->end =  $dt2;
                $setting->token = $request->input('token');
                $setting->current = "0";
                $setting->save();
                
                return back()->with('success', 'Successfully set a new Semester Dates');
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
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
        
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $settingUpt = Setting::where('current','=', '1')->update(['current' => '0']);
        $setting = Setting::where('id','=', $id)->update(['current' => '1']);
        return back()->with('success', 'Successfuly Set as Current Semester');
    }

    public function deleteAll(Request $request)
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') {
                if($request->delete != NULL)
                {
                    $delete = $request->delete;
                    if ($request->input('action') == 'Delete' )
                    {

                        if ($request->input('archive') == '1') {
                            DB::table("history_school_year")->whereIn('id', $delete)->where('current','<>',1)->delete();
                            DB::table("history_printing_logs")->whereIn('school_year_id', $delete)->delete();
                            DB::table("history_login_logs")->whereIn('sy_id', $delete)->delete();
                            return back()->with('success', 'Successfuly deleted all selected record');
                        }

                        DB::table("school_year")->whereIn('id', $delete)->where('current','<>',1)->delete();
                        DB::table("printing_logs")->whereIn('school_year_id', $delete)->where('school_year_id','<>',Setting::where('current','=','1')->first()->id)->delete();
                        DB::table("login_logs")->whereIn('sy_id', $delete)->where('sy_id','<>',Setting::where('current','=','1')->first()->id)->delete();
                        DB::table("schedules")->whereIn('sy_id', $delete)->where('sy_id','<>',Setting::where('current','=','1')->first()->id)->delete();
                        return back()->with('success', 'Successfuly deleted all selected record');
                
                    }

                    if ($request->input('action') == 'Archive' )
                    {
                        if(Setting::whereIn('id', $delete)->where('current','=', '1')->count() > 0)
                        {
                            return back()->with('error', 'Failed to archive record/s one of the selected record is currently set as currect School Year');
                        }
                        
                        //archive account logs records
                        $get_logs = Logs::whereIn('sy_id', $delete)->select(array('id_number','reason','date_login','time_from','time_to','sy_id','room_id','subject_id'));
                        $binding_logs = $get_logs->getBindings();
                        $insert_logs_query = 'INSERT into history_login_logs (id_number,reason,date_login,time_from,time_to,sy_id,room_id,subject_id) '
                                        . $get_logs->toSql();
                                        
                        \DB::insert($insert_logs_query, $binding_logs);
                        

                        //archive account printing logs
                        $get_printing_logs = printing_logs::whereIn('school_year_id', $delete)->select(array('student_id','reason','number_of_paper','status','school_year_id'));
                        $binding_printing_logs = $get_printing_logs->getBindings();
                        $insert_printing_logs_query = 'INSERT into history_printing_logs (student_id,reason,number_of_paper,status,school_year_id) '
                                        . $get_printing_logs->toSql();
                                        
                        \DB::insert($insert_printing_logs_query, $binding_printing_logs);

                        //archive school years
                        $get_school_year = Setting::whereIn('id', $delete)->select(array('id', 'semester', 'start', 'end', 'token', 'current'));
                        $binding_school_year = $get_school_year->getBindings();
                        $insert_school_year_query = 'INSERT into history_school_year (id,semester,start,end,token,current) '
                                        . $get_school_year->toSql();
                                        
                        \DB::insert($insert_school_year_query, $binding_school_year);

                         //archive schedules
                         $get_school_year = schedule::whereIn('sy_id', $delete)->select(array('id', 'hour_start', 'hour_end', 'day_of_the_week', 'code', 'room_id', 'faculty_id', 'sy_id', 'subject_id'));
                         $binding_school_year = $get_school_year->getBindings();
                         $insert_school_year_query = 'INSERT into history_schedules (id,hour_start,hour_end,day_of_the_week,code,room_id,faculty_id,sy_id,subject_id) '
                                         . $get_school_year->toSql();
                                         
                         \DB::insert($insert_school_year_query, $binding_school_year);

                        
                        DB::table("login_logs")->whereIn('sy_id', $delete)
                        ->delete();
                        DB::table("printing_logs")->whereIn('school_year_id', $delete)
                        ->delete();
                        DB::table("school_year")->whereIn('id', $delete)
                        ->delete();
                        DB::table("schedules")->whereIn('sy_id', $delete)
                        ->delete();
                        return back()->with('success', 'Successfuly Archived all selected record/s');
                            
                    }

                    if ($request->input('action') == 'Restore' )
                    {

                        //archive account logs records
                        $get_logs = history_logs::whereIn('sy_id', $delete)->select(array('id_number','reason','date_login','time_from','time_to','sy_id','room_id','subject_id'));
                        $binding_logs = $get_logs->getBindings();
                        $insert_logs_query = 'INSERT into login_logs (id_number,reason,date_login,time_from,time_to,sy_id,room_id,subject_id) '
                                        . $get_logs->toSql();
                                        
                        \DB::insert($insert_logs_query, $binding_logs);
                        

                        //archive account printing logs
                        $get_printing_logs = history_printing_log::whereIn('school_year_id', $delete)->select(array('student_id','reason','number_of_paper','status','school_year_id'));
                        $binding_printing_logs = $get_printing_logs->getBindings();
                        $insert_printing_logs_query = 'INSERT into printing_logs (student_id,reason,number_of_paper,status,school_year_id) '
                                        . $get_printing_logs->toSql();
                                        
                        \DB::insert($insert_printing_logs_query, $binding_printing_logs);

                        //archive school years
                        $get_school_year = history_school_year::whereIn('id', $delete)->select(array('id', 'semester', 'start', 'end', 'token', 'current'));
                        $binding_school_year = $get_school_year->getBindings();
                        $insert_school_year_query = 'INSERT into school_year (id,semester,start,end,token,current) '
                                        . $get_school_year->toSql();
                                        
                        \DB::insert($insert_school_year_query, $binding_school_year);

                         //archive schedules
                         $get_school_year = history_schedule::whereIn('sy_id', $delete)->select(array('id', 'hour_start', 'hour_end', 'day_of_the_week', 'code', 'room_id', 'faculty_id', 'sy_id', 'subject_id'));
                         $binding_school_year = $get_school_year->getBindings();
                         $insert_school_year_query = 'INSERT into schedules (id,hour_start,hour_end,day_of_the_week,code,room_id,faculty_id,sy_id,subject_id) '
                                         . $get_school_year->toSql();
                                         
                         \DB::insert($insert_school_year_query, $binding_school_year);

                        Return 'catch';
                         DB::table("history_login_logs")->whereIn('sy_id', $delete)
                         ->delete();
                         DB::table("history_printing_logs")->whereIn('school_year_id', $delete)
                         ->delete();
                         DB::table("history_school_year")->whereIn('id', $delete)
                         ->delete();
                         DB::table("history_schedules")->whereIn('sy_id', $delete)
                         ->delete();
                        
                        
                        return back()->with('success', 'Successfuly Restored all selected record/s');
                            
                    }
                }
                    return back();
            }

            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
    }
}

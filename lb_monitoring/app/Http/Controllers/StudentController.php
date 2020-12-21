<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borrower;
use App\account_information;
use App\User;
use App\Logs;
use App\printing_logs;
use App\history_account_information;
use App\history_user;
use App\history_logs;
use App\history_printing_log;
use App\School_year;
use App\Setting;
Use DB;
use Carbon\Carbon;
use App\Imports\StudentImport;
use App\Exports\UsersExportStudent;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$students = Borrower::where('type','=','Student')->get();
        
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                $students = DB::table('account_information')
                ->join('users','users.id_number','=','account_information.id_number')
                ->where('account_information.type','=','Student')
                ->select('account_information.id','account_information.id_number','account_information.fullname','users.email')
                ->get();
                $non_print = DB::table('account_information')->whereNotIn('id_number',function($query)
                {
                    $query->select('student_id')
                          ->from('printing_logs')
                          ->where('status','=',2)
                          ->where('school_year_id','=',Setting::where('current','=',1)->first()->id);
                })->where('account_information.type','=','Student')->select('id_number')->get();
                //return $non_print;
                $printing_expend = DB::table('printing_logs')
                ->where('school_year_id','=',School_year::where('Current','=','1')->first()->id)
                ->where('status','=',2)
                ->select('student_id',DB::raw('SUM(number_of_paper) as printing_cost'))
                ->groupBy('student_id')
                ->get();
                //$non_print = DB::table('printing_logs')->select('student_id')->get();
                #return implode(",", $list);
                return view('students.index', compact('students','printing_expend','non_print'))->with('no', 1);
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
    }


    public function histindex()
    {
        //$students = Borrower::where('type','=','Student')->get();
        
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                $students = DB::table('history_account_information')
                ->join('history_users','history_users.id_number','=','history_account_information.id_number')
                ->where('history_account_information.type','=','Student')
                ->select('history_account_information.*','history_users.email')
                ->get();
                return view('students.histindex', compact('students'))->with('no', 1);
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
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                return view('students.create');
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
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                if($request->input('method') == 'import')
                {
                    if ($request->hasFile('excel_upload')) 
                    {
                        Excel::import(new StudentImport, request()->file('excel_upload')); 
                        return redirect('/students')->with('success', 'Upload Successful!');
                    }
                    return back();
                    
                }
                
                $this->validate($request, [
                    'id_number' => ['required', 'integer'],
                    //'name' => ['required', 'regex:/[a-zA-Z\\s]\\,[a-zA-Z\\s]/|/[a-zA-Z\\s]', 'max:255'],
                    'name' => ['required', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                $student = new account_information;
                $student->id_number = $request->input('id_number');
                $student->fullname = $request->input('name');
                $student->type = 'Student';
                $student->save();

                $account = new User;
                $account->id_number = $request->input('id_number');
                $account->email = $request->input('email');
                $account->password = Hash::make($request->input('password'));
                $account->save();
                return back()->with('success', 'New Student Record Created');
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
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                $students = DB::table('account_information')
                ->join('users','users.id_number','=','account_information.id_number')
                ->where('account_information.type','=','Student')
                ->where('account_information.id','=',$id)
                ->select('account_information.*','users.email')
                ->get()->first();
                $logs = DB::table('account_information')
                ->join('login_logs','login_logs.id_number','=','account_information.id_number')
                ->where('account_information.id','=',$id)
                ->select('login_logs.*','account_information.*')
                ->get();
                return view('students.show', compact('students', 'logs'));
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
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
        if(\Auth::check()){
            if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
        
                $this->validate($request, [
                    'current_password' => ['required', 'string', 'min:8'],
                    'new_password' => ['required', 'string', 'min:8'],
                    'repeat_password' => ['required', 'string', 'min:8'],
                ]);
                
                    if (Hash::check($request->input('current_password'),User::where('id_number','=',$id)->first()->password)) {
                        if (Hash::check($request->input('new_password'),User::where('id_number','=',$id)->first()->password)) {
                            return redirect('/students/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'New password must not be the same with Current Password');
                        }
                        if($request->input('new_password') == $request->input('repeat_password')){
                            $new_password = User::find(User::where('id_number','=',$id)->first()->id);
                            $new_password->password = Hash::make($request->input('new_password'));
                            $new_password->save();

                            return redirect('/students/'.Borrower::where('id_number','=',$id)->first()->id)->with('success', 'Password has been updated');
                        }

                        return redirect('/students/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'New password must be the same with Confirm Password');

                    }
                    return redirect('/students/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'Entered Current Password is not the same with the set Current Passowrd');
            }
            $title = 'No Sufficient Access';
            $body = 'Only Super Admin can Access this Page';
            return view('error', compact('title','body'));
        }
        return redirect('/login');
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
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') 
            { 
                $delete = $request->delete;
                if($request->input('delete') != NULL)
                {
                    

                    if ($request->input('action') == 'Delete' )
                    {
                        
                        if ($request->input('archive') == '1') {
                            DB::table("history_account_information")->whereIn('id_number', $delete)
                            ->where('type','<>','Super Admin')
                            ->delete();
                            DB::table("history_users")->whereIn('id_number', $delete)
                            ->delete();
                            return back()->with('success', 'Successfuly deleted all selected record');
                        }
                            DB::table("account_information")->whereIn('id_number', $delete)
                            ->where('type','<>','Super Admin')
                            ->delete();
                            DB::table("users")->whereIn('id_number', $delete)
                            ->delete();
                            return back()->with('success', 'Successfuly deleted all selected record');
                            
                    }

                    if ($request->input('action') == 'Archive' )
                    {
                        //archive account information
                        $get_account_information = account_information::whereIn('id_number', $delete)->select(array('id_number','fullname','type'));
                        $binding_account_infomation = $get_account_information->getBindings();
                        $insert_account_information_query = 'INSERT into history_account_information (id_number,fullname,type) '
                                        . $get_account_information->toSql();

                        \DB::insert($insert_account_information_query, $binding_account_infomation);

                        //archive account credentials
                        $get_user = User::whereIn('id_number', $delete)->select(array('id_number','email','password'));
                        $binding_user = $get_user->getBindings();
                        $insert_user_query = 'INSERT into history_users (id_number,email,password) '
                                        . $get_user->toSql();

                        \DB::insert($insert_user_query, $binding_user);
                        

                        //archive account logs records
                        $get_logs = Logs::whereIn('id_number', $delete)->select(array('id_number','reason','date_login','time_from','time_to','sy_id','room_id','subject_id'));
                        $binding_logs = $get_user->getBindings();
                        $insert_logs_query = 'INSERT into history_login_logs (id_number,reason,date_login,time_from,time_to,sy_id,room_id,subject_id) '
                                        . $get_logs->toSql();
                                        
                        \DB::insert($insert_logs_query, $binding_logs);
                        

                        //archive account printing logs
                        $get_printing_logs = printing_logs::whereIn('student_id', $delete)->select(array('student_id','reason','number_of_paper','status','school_year_id'));
                        $binding_printing_logs = $get_printing_logs->getBindings();
                        $insert_printing_logs_query = 'INSERT into history_printing_logs (student_id,reason,number_of_paper,status,school_year_id) '
                                        . $get_printing_logs->toSql();
                                        
                        \DB::insert($insert_printing_logs_query, $binding_printing_logs);

                        DB::table("account_information")->whereIn('id_number', $delete)
                        ->where('type','<>','Super Admin')
                        ->delete();
                        DB::table("users")->whereIn('id_number', $delete)
                        ->delete();
                        DB::table("login_logs")->whereIn('id_number', $delete)
                        ->delete();
                        DB::table("printing_logs")->whereIn('student_id', $delete)
                        ->delete();
                        return back()->with('success', 'Successfuly Archived all selected record/s');
                            
                    }

                    if ($request->input('action') == 'Restore' )
                    {

                        //Restore account credentials
                        $get_user = history_user::whereIn('id_number', $delete)->select(array('id_number','email','password'));
                        $binding_user = $get_user->getBindings();
                        $insert_user_query = 'INSERT into users (id_number,email,password) '
                                        . $get_user->toSql();

                        \DB::insert($insert_user_query, $binding_user);


                        //Restore account information
                        $get_account_information = history_account_information::whereIn('id_number', $delete)->select(array('id_number','fullname','type'));                        
                        $binding_account_infomation = $get_account_information->getBindings();
                        $insert_account_information_query = 'INSERT into account_information (id_number,fullname,type)'
                                        . $get_account_information->toSql();

                        \DB::insert($insert_account_information_query, $binding_account_infomation);

                        
                        
                            
                        
                            $get_logs = history_logs::whereIn('id_number', $delete)->select(array('id_number','reason','date_login','time_from','time_to','sy_id','room_id','subject_id'));
                            $binding_logs = $get_user->getBindings();
                            $insert_logs_query = 'INSERT into login_logs (id_number,reason,date_login,time_from,time_to,sy_id,room_id,subject_id) '
                                            . $get_logs->toSql();
                                            
                            \DB::insert($insert_logs_query, $binding_logs);

                            DB::table("history_login_logs")->whereIn('id_number', $delete)
                            ->delete();
                        
                        
                        

                        
                            $get_printing_logs = history_printing_log::whereIn('student_id', $delete)->select(array('student_id','reason','number_of_paper','status','school_year_id'));
                            $binding_printing_logs = $get_printing_logs->getBindings();
                            $insert_printing_logs_query = 'INSERT into printing_logs (student_id,reason,number_of_paper,status,school_year_id) '
                                            . $get_printing_logs->toSql();
                                            
                            \DB::insert($insert_printing_logs_query, $binding_printing_logs);

                            DB::table("history_printing_logs")->whereIn('student_id', $delete)
                            ->delete();
                        
                        
                        
                        DB::table("history_account_information")->whereIn('id_number', $delete)
                        ->where('type','<>','Super Admin')
                        ->delete();
                        DB::table("history_users")->whereIn('id_number', $delete)
                        ->delete();
                        
                        
                        return back()->with('success', 'Successfuly Restored all selected record/s');
                            
                    }
                }

                

                return back()->with('warning', 'No record was selected');
        }
        $title = 'No Sufficient Access';
        $body = 'Only Super Admin can Access this Page';
        return view('error', compact('title','body'));
    }
    return redirect('/login');
          
    }
}

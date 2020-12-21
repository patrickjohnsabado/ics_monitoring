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
Use DB;
use Carbon\Carbon;
use App\Imports\StudentImport;
use App\Exports\UsersExportStudent;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AdminContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') {    
                $admins = DB::table('account_information')
                ->join('users','users.id_number','=','account_information.id_number')
                ->where('account_information.type','=','Super Admin')
                ->select('account_information.id','account_information.id_number','account_information.fullname','users.email')
                ->get();
                return view('admins.index', compact('admins'))->with('no', 1);
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
                return view('admins.create');
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
                
                
                $this->validate($request, [
                    'id_number' => ['required', 'unique:users'],
                    //'name' => ['required', 'regex:/[a-zA-Z\\s]\\,[a-zA-Z\\s]/|/[a-zA-Z\\s]', 'max:255'],
                    'name' => ['required', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);

                $admin = new account_information;
                $admin->id_number = $request->input('id_number');
                $admin->fullname = $request->input('name');
                $admin->type = 'Super Admin';
                $admin->save();

                $account = new User;
                $account->id_number = $request->input('id_number');
                $account->email = $request->input('email');
                $account->password = Hash::make($request->input('password'));
                $account->save();
                return back()->with('success', 'New Admin Account Created');
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
                ->where('account_information.type','=','Super Admin')
                ->where('account_information.id','=',$id)
                ->select('account_information.*','users.email')
                ->get()->first();
                $logs = DB::table('account_information')
                ->join('login_logs','login_logs.id_number','=','account_information.id_number')
                ->where('account_information.id','=',$id)
                ->select('login_logs.*','account_information.*')
                ->get();
                return view('admins.show', compact('students', 'logs'));
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
                            return redirect('/admins/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'New password must not be the same with Current Password');
                        }
                        if($request->input('new_password') == $request->input('repeat_password')){
                            $new_password = User::find(User::where('id_number','=',$id)->first()->id);
                            $new_password->password = Hash::make($request->input('new_password'));
                            $new_password->save();
                            
                            return redirect('/admins/'.Borrower::where('id_number','=',$id)->first()->id)->with('success', 'Password has been updated');
                        }

                        return redirect('/admins/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'New password must be the same with Confirm Password');

                    }
                    return redirect('/admins/'.Borrower::where('id_number','=',$id)->first()->id)->with('error', 'Entered Current Password is not the same with the set Current Passowrd');
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
                        
                    
                            DB::table("account_information")->whereIn('id_number', $delete)
                            ->delete();
                            DB::table("users")->whereIn('id_number', $delete)
                            ->delete();
                            return back()->with('success', 'Successfuly deleted all selected record');
                            
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
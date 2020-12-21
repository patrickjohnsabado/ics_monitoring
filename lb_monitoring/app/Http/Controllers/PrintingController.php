<?php

namespace App\Http\Controllers;

use App\account_information;
use App\printing_settings;
use App\printing_logs;
use App\School_year;
use App\Setting;
use DB;
use Illuminate\Http\Request;

class PrintingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::check()){
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $prints = DB::table('printing_logs')
            ->join('account_information','printing_logs.student_id','=','account_information.id_number')
            ->where('printing_logs.school_year_id','=',Setting::where('current','=',1)->first()->id)
            ->select('printing_logs.*','account_information.*','account_information.id_number AS p_id_number','printing_logs.id AS p_id')
            ->get();
            $students = account_information::where('type','=','Student')->get();
            $setting_color = DB::table('printing_setting')->distinct()->get(['color']);
            $setting_size = DB::table('printing_setting')->distinct()->get(['size']);
            $setting = printing_settings::all();
            $non_print = DB::table('account_information')->whereNotIn('id_number',function($query)
                {
                    $query->select('student_id')
                          ->from('printing_logs')
                          ->where('status','=',2);
                })->where('account_information.type','=','Student')->select('id_number')->get();
            $printing_expend = DB::table('printing_logs')
                ->where('school_year_id','=',School_year::where('Current','=','1')->first()->id)
                ->where('status','=',2)
                ->select('student_id',DB::raw('SUM(number_of_paper) as printing_cost'))
                ->groupBy('student_id')
                ->get();
            return view('printing.index', compact('prints','setting','students','setting_color','setting_size','printing_expend','non_print'))->with('no', 1)->with('no2', 1);
        }

        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student' ) {
            $prints = DB::table('printing_logs')
            ->join('account_information','printing_logs.student_id','=','account_information.id_number')
            ->where('printing_logs.school_year_id','=',Setting::where('current','=',1)->first()->id)
            ->where('account_information.id_number','=',account_information::where('id_number','=',auth()->user()->id_number)->first()->id_number)
            ->select('printing_logs.*','account_information.*','account_information.id_number AS p_id_number','printing_logs.id AS p_id')
            ->get();
            $students = account_information::where('id_number','=',auth()->user()->id_number)->get();
            $setting_color = DB::table('printing_setting')->distinct()->get(['color']);
            $setting_size = DB::table('printing_setting')->distinct()->get(['size']);
            $setting = printing_settings::all();
            $non_print = DB::table('account_information')->whereNotIn('id_number',function($query)
                {
                    $query->select('student_id')
                          ->from('printing_logs')
                          ->where('status','=',2);
                })->where('account_information.type','=','Student')->select('id_number')->get();
            $printing_expend = DB::table('printing_logs')
                ->where('school_year_id','=',School_year::where('Current','=','1')->first()->id)
                ->where('status','=',2)
                ->select('student_id',DB::raw('SUM(number_of_paper) as printing_cost'))
                ->groupBy('student_id')
                ->get();
            
            return view('printing.index', compact('prints','setting','students','setting_color','setting_size','printing_expend','non_print'))->with('no', 1)->with('no2', 1);
        }

        $title = 'No Sufficient Access';
        $body = 'Only Super Admin can Access this Page';
        return view('error', compact('title','body'));
        }
        return redirect('/login');
    }

    public function histindex()
    {
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $prints = DB::table('history_printing_logs')
            ->join('history_account_information','history_printing_logs.student_id','=','history_account_information.id_number')
            ->select('history_printing_logs.*','history_account_information.*','history_account_information.id_number AS p_id_number','history_printing_logs.id AS p_id')
            ->get();

            $prints_2 = DB::table('history_printing_logs')
            ->join('account_information','history_printing_logs.student_id','=','account_information.id_number')
            ->select('history_printing_logs.*','account_information.*','account_information.id_number AS p_id_number','history_printing_logs.id AS p_id')
            ->get();
            return view('printing.histindex', compact('prints','prints_2'))->with('no2', 1);
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
        
        //return auth()->user()->id_number;
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' || account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student') {
            
            
            
            
        
            $print = new printing_logs;
            $print->student_id = $request->input('user');
            $print->reason = $request->input('name');
            $print->number_of_paper = $request->input('page');
            $print->status = '1';
            $print->school_year_id = School_year::where('Current','=','1')->first()->id;
            $print->save();
            return back()->with('success', 'Successfully added a new printing setting');
            return 'error';
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
    public function destroy(Request $request, $id)
    {
        if ($request->input('action') == 'Pending') {
                
            $status = printing_logs::where('id','=',$id)->update(['status' => '1']);
            return back()->with('success', 'Successfuly Set Document '.printing_logs::where('id','=',$id)->first()->reason.' as Pending');
        }

        if ($request->input('action') == 'Accept') {
            $status = printing_logs::where('id','=',$id)->update(['status' => '2']);
            return back()->with('success', 'Successfuly Accepted Document '.printing_logs::where('id','=',$id)->first()->reason);
        }

        if ($request->input('action') == 'Deny') {
            $status = printing_logs::where('id','=',$id)->update(['status' => '3']);
            return back()->with('success', 'Successfuly Denied Document '.printing_logs::where('id','=',$id)->first()->reason);
        }
        return 'catch';
    }

    public function deleteAll(Request $request)
    {

        if(\Auth::check()){
            if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin') { 
                
                
                
                if($request->delete != NULL) {
                    
                    if ($request->input('archive') == '1') {
                        $delete = $request->delete;
                        DB::table("history_printing_logs")->whereIn('id', $delete)->delete();
                        return back()->with('success', 'Successfuly deleted all selected record');
                    }
                    $delete = $request->delete;
                    DB::table("printing_logs")->whereIn('id', $delete)->delete();
                    return back()->with('success', 'Successfuly deleted all selected record');
                }
                    return back();
            }
        }
        return redirect('/login');
    }


}

<?php

namespace App\Http\Controllers;

use App\Subject;
use App\account_information;
use App\School_year;
use DB;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(account_information::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) {
            $subjects = Subject::all();
            //return $subjects;
            return view('subjects.index', compact('subjects'));
        }
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
        //return account_information::where('id_number','=',$request->input('user'))->first()->id_number;
        //return $request;
        //return School_year::where('Current','=','1')->first();
        //return Subject::where('code','=',$request->input('code'))->where('sy_id','=',School_year::where('Current','=','1')->first()->id)->count();
        if(Subject::where('course_number','=',$request->input('course_number'))->count() > 0)
        {
            return back()->with('Error', 'Failed to add Subject. Subject with course number "'.$request->input('course_number').'" is already existing in the System.');
        }
        $subject = new Subject;
        $subject->course_number = $request->input('course_number');
        $subject->description = $request->input('description');
        $subject->unit = $request->input('unit');
        $subject->save();
        return back()->with('success', 'Successfuly created a new Subject');
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
                        if (DB::table("schedules")->whereIn('subject_id', $delete)->count() > 0) {
                            return back()->with('error', 'Failed to Delete this Subject/s, There are Schedules mapped to this Subjects');
                        }
                        
                        DB::table("subjects")->whereIn('id', $delete)->delete();
                        return back()->with('success', 'Delete Successful');
                    }
                        return back();
            }
            return redirect('/login');
        }
    }
}

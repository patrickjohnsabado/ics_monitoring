<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Borrower;
use App\Material;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Borrower::where('type','=','Student')->count();
        $faculties = Borrower::where('type','=','Faculty')->count();
        $borrowed_c = DB::table('borrowed')
        ->whereNull('returned_date')
        ->count();
        $borrowed_p = DB::table('borrowed')
        ->whereNotNull('returned_date')
        ->count();
        $materials_av = Material::join('classifications','classifications.id','=','materials.classification_id')->where('classifications.classification','=','Audio Visual')->count();

        $materials_p = Material::join('classifications','classifications.id','=','materials.classification_id')->where('classifications.classification','<>','Audio Visual')->count();
        $dt = Carbon::now();
        $top = DB::table('logs')
        ->join('borrowers','borrowers.id','=','logs.borrowers_id')
        ->where('borrowers.type','=','Student')
        ->whereMonth('logs.created_at','=',$dt->month)
        ->select('borrowers.name','borrowers.section', DB::raw('COUNT(logs.borrowers_id) as number'))
        ->groupBy('logs.borrowers_id')
        ->orderBy('number', 'desc')
        ->take(10)
        ->get();

        $sections = DB::table('logs')->join('borrowers','borrowers.id','=','logs.borrowers_id')->where('borrowers.type','=','Student')->whereMonth('logs.created_at','=',$dt->month)->select('section',DB::raw('COUNT(borrowers_id) as numbers'))->groupBy('section')->orderBy('numbers','desc')->get();
        $section_c = DB::table('borrowers')->where('type','=','Student')->select('section', DB::raw('COUNT(section) as section_c'))->groupBy('section')->get();
        
        return view('welcome', compact('students','faculties','borrowed_c','borrowed_p','materials_p','materials_av','top','sections','section_c'));
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
        //
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
}

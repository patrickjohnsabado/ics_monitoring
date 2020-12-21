<?php

namespace App\Exports;

use App\Logs;
use App\Borrower;
use DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportLogsAll implements FromQuery, ShouldAutoSize, WithHeadings
{
    use Exportable;
    public function query()
    {   
        if(\Auth::check()){
            if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Super Admin' ) { 
                
                return Logs::query()
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->join('rooms','rooms.id','=','login_logs.room_id')
                            ->join('schedules','schedules.id','=','login_logs.subject_id')
                            ->join('subjects','schedules.subject_id','=','subjects.id')
                            ->select('fullname','users.id_number','users.email','account_information.type','login_logs.date_login','login_logs.time_from','login_logs.time_to','school_year.semester','school_year.start','school_year.end','rooms.room_number','room_type','schedules.code','subjects.course_number','subjects.description');
            }

            if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Faculty') { 
                return Logs::query()
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->where('account_information.type','=','Student')
                            ->select('fullname','users.id_number','users.email','account_information.type','login_logs.date_login','login_logs.time_from','login_logs.time_to','school_year.semester','school_year.start','school_year.end');
            }

            if(Borrower::where('id_number','=',auth()->user()->id_number)->first()->type == 'Student') {
                return Logs::query()
                            ->join('account_information','account_information.id_number','=','login_logs.id_number')
                            ->join('users','users.id_number','=','account_information.id_number')
                            ->join('school_year','login_logs.sy_id','=','school_year.id')
                            ->where('account_information.id_number','=',auth()->user()->id_number)
                            ->select('fullname','users.id_number','users.email','account_information.type','login_logs.date_login','login_logs.time_from','login_logs.time_to','school_year.semester','school_year.start','school_year.end');
            }
        }
        return redirect('/login');
    }
    public function headings(): array
    {
        return [
            'Full Name',
            'ID Number',
            'Email',
            'Visitor Type',
            'Date Visit',
            'From',
            'To',
            'Semester',
            'Start',
            'End',
            'Room Number',
            'Room Type',
            'Code',
            'Course Number',
            'Description',
        ];
    }
}

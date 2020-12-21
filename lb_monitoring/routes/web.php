<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Borrow Material/s Route/s


Auth::routes();

Route::get('/', function () {
    return redirect('/logs');
});

Route::get('/home', function () {
    return redirect('/logs');
});

//Faculty/s Route/s
Route::resource('/faculties','FacultyController');
Route::get('/faculty/excel', 'FacultyController@excelAll');
Route::post('/deleteFaculty', 'FacultyController@deleteAll');

//Student/s Route/s
Route::resource('/students','StudentController');
Route::get('/student/excel', 'StudentController@excelAll');
Route::post('/deleteStudent', 'StudentController@deleteAll');

//Log/s Route/s
Route::resource('/logs','LogsController');
Route::post('/deleteLogs', 'LogsController@deleteAll');
Route::post('/logs/excel', 'LogsController@excel');
Route::get('/logs/excel/all', 'LogsController@excelAll');
Route::get('/logs/excel/today', 'LogsController@excelToday');

Route::resource('/settings','SettingController');
Route::post('/deleteSetting', 'SettingController@deleteAll');


//Calendar Route/s
Route::get('/calendar','CalendarController@calendar');

//Reservation
Route::resource('/reservation','CalendarController');
Route::post('/deleteReservation', 'CalendarController@deleteAll');

//Room Route/s
Route::resource('/room','RoomController');
Route::get('/roomutil','RoomController@utilindex');
Route::get('/openlab','RoomController@openLab');
Route::get('/lab','RoomController@lab');
Route::post('/deleteRoom', 'RoomController@deleteAll');
Route::get('room/{room_id}/{room_type}/{date}', 'RoomController@roomShow');

//Subject Route/s
Route::resource('/subjects','SubjectController');
Route::post('/deleteSubject', 'SubjectController@deleteAll');

//Schedule Route/s
Route::resource('/schedules','ScheduleContoller');
Route::post('/deleteSchedules', 'ScheduleContoller@deleteAll');

//Printing Route/s
Route::resource('/print','PrintingController');
Route::post('/printing_setting', 'PrintingController@storeSetting');
Route::post('/deletePrint', 'PrintingController@deleteAll');
Route::post('/deletePrintSetting', 'PrintingController@deleteAllSetting');

//Archived Route/s
Route::get('/histfaculties','FacultyController@histindex');
Route::get('/histstudents','StudentController@histindex');
Route::get('/histlogs','LogsController@histindex');
Route::get('/histprint','PrintingController@histindex');
Route::get('/histsettings','SettingController@histindex');
Route::get('/histschedules','ScheduleContoller@histindex');

//Student/s Route/s
Route::resource('/admins','AdminContoller');
Route::post('/deleteAdmin', 'AdminController@deleteAll');
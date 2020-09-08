<?php

use Illuminate\Support\Facades\Route;
use App\Notifications\NewReport;
use App\User;


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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/index', 'UserPatientController@home')->name('user.index');
Route::get('/userconsultation', 'UserPatientController@userconsultation');
Route::post('/sendreport/{consultation}', 'UserPatientController@store')->name('user.addreport');

Route::get('/pickup/{prescribedlist}', 'PharmacyController@pickup')->name('pharmacy.pickup');
Route::get('/pharmacy', 'PharmacyController@home');
Route::get('/pharmacylist', 'PharmacyController@list')->name('pharmacy.list');
Route::get('/pharmacysearch', 'PharmacyController@search')->name('pharmacy.search');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/list', 'HomeController@list')->name('patient.list');

Route::get('/patient/{user}','PatientController@user')->name('patient.records');
Route::get('/patientrecords/{user}','PatientController@index');
Route::get('/pharmacies', 'PatientController@pharmacies');
Route::get('/search', 'HomeController@search')->name('patient.search');
Route::get('/readnotification/{consultation}', 'HomeController@readnotification')->name('readnotification');

Route::post('/addpatient/user','PatientController@store')->name('patient.adduser');

Route::post('/updatepatient/{user}','PatientController@update')->name('patient.update');

Route::get('/consultation/{consultation}','ConsultationController@list')->name('consultation.view');
Route::get('/consultationshow/{consultation}','ConsultationController@show')->name('consultation.view');
Route::get('/consultationview/{consultation}','ConsultationController@view');
Route::post('/consultation/{user}','ConsultationController@store')->name('consultation.store');

Route::post('/prescription/{consultation}','PrescriptionController@store')->name('prescription.store');
Route::post('/prescription/delete/{prescription}','PrescriptionController@delete')->name('prescription.delete');

route::get('/x', function (){
	$user = Auth::user();
	$user->notify(new NewReport(User::findOrFail(3)));
});



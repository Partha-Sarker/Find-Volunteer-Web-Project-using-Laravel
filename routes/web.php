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

Route::get('/', 'PagesController@getHome');
Route::get('/editProfile', 'PagesController@getEditProfile');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/contact', 'PagesController@getContactUs');
Route::get('/change_pass', 'PagesController@getChangePassword')->name('changePass');
Route::resource('volunteer', 'VolunteerController');
Route::resource('organization', 'OrganizationController');
Route::get('organization/{organization_id}/events', 'OrganizationController@showEvents')->name('organization.events');
Route::resource('member', 'MemberController');
Route::resource('event', 'EventController');
Route::resource('event/{event_id}/event_photo', 'EventPhotoController');
Route::resource('event/{id}/circular', 'CircularController');
Route::post('{circular_id}/join', 'VolunteerController@sendJoinRequest')->name('volunteer.joinRequest');
Route::post('{id}/{circular_id}/{volunteer_id}/join', 'CircularController@validateJoinRequest')->name('circular.validateRequest');
Route::post('{volunteer_id}/rating', 'OrganizationController@rate')->name('organization.rate');
Route::resource('circular/{id}/comment', 'CommentController');
Auth::routes(['verify' => true]);

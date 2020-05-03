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
Route::get('test-email', function() {
    Mail::raw('Laravel Test Email!', function($message){
        $message->to('ta.shaikat@gmail.com');
    });
});



Route::get ('/', 'HomeController@index');
Route::post ('email_subscribe', 'HomeController@email_subscribe');


Route::get ('t/dashboard', 'TeacherController@dashboard')->name('teacher.dashboard');
//Route::get ('t/toolkit/create', 'ToolkitController@create')->name('teacher.toolkit.create');
//Route::post ('toolkit/store', 'ToolkitController@store')->name('teacher.toolkit.store');
//Route::get ('toolkit/edit/{id}', 'ToolkitController@toolkit_edit')->name('teacher.toolkit.edit');


Route::get ('t/{username}', 'TeacherController@index');
Route::post ('add_work_experience', 'TeacherController@add_work_experience');
Route::post ('add_academics', 'TeacherController@add_academics');
Route::post ('add_skills', 'TeacherController@add_skills');
Route::get ('remove/{type}/{id}', 'TeacherController@remove_profile_item');

Route::get ('s/{username}', 'SchoolController@index');


// admin routes
Route::get ('dashboard', 'AdminController@index')->name('dashboard');
Route::get ('admin/course/create', 'CourseController@create')->name('course.create');
Route::post ('admin/course/store', 'CourseController@store')->name('course.store');
Route::get ('admin/course/edit/{id}', 'CourseController@course_edit')->name('course.edit');
Route::get ('admin/course/objective/edit/{id}', 'CourseController@courseObjectiveEdit')->name('course.objective.edit');
Route::post ('admin/course/objective/update/{id}', 'CourseController@courseSequenceUpdate')->name('course.objective.update');

Route::post ('admin/course/update/{id}', 'CourseController@course_video_update')->name('course.update.edit');
Route::post ('admin/course/quiz/update/{id}', 'CourseController@course_quiz_update')->name('course.quiz.update');


Route::get ('toolkit/create', 'ToolkitController@create')->name('toolkit.create');
Route::post ('toolkit/store', 'ToolkitController@store')->name('toolkit.store');
Route::post ('toolkit/update/{id}', 'ToolkitController@toolkitDetailsUpdate')->name('toolkit.update');
Route::post ('toolkit/video/create/{id}', 'ToolkitController@videoCreate')->name('toolkit.video.create');
Route::post ('toolkit/quiz/create/{id}', 'ToolkitController@quizCreate')->name('toolkit.quiz.create');
Route::post ('toolkit/question/create/{id}', 'ToolkitController@questionCreate')->name('toolkit.question.create');

Route::get ('toolkit/edit/{id}', 'ToolkitController@toolkit_edit')->name('toolkit.edit');
Route::post ('toolkit/video/update/{id}', 'ToolkitController@toolkit_video_update')->name('toolkit.video.edit');
Route::post ('toolkit/quiz/update/{id}', 'ToolkitController@toolkit_quiz_update')->name('toolkit.quiz.update');


Route::post ('admin/load_content', 'AdminController@load_content');
Route::post ('admin/load_question', 'AdminController@load_question');
// admin routes ends


Route::get ('all', 'AllController@index');

Route::get ('course', 'CourseController@index');

Route::get ('contact_us', 'ContactController@index');
Route::get ('overview/{course_toolkit}/{slug}', 'ContentController@overview');
Route::get ('view/{course_toolkit}/{slug}', 'ContentController@index');
Route::post ('load_content', 'ContentController@load_content');
Route::post ('load_question', 'ContentController@load_question'); //newly created
Route::post ('load_result', 'ContentController@load_result'); //newly created
Route::post ('verify_track_history', 'ContentController@verify_track_history');
Route::post ('update_track_history', 'ContentController@update_track_history');
Route::post ('enroll_into_course', 'ContentController@enroll_into_course');
Route::post ('rate_a_course', 'ContentController@rate_a_course');
Route::post ('retake_course', 'ContentController@retake_course');
Route::post ('verify_question', 'ContentController@verify_question');

Route::get ('settings', 'SettingsController@index');
Route::post ('updateInfo', 'SettingsController@updateInfo')->name('updateInfo');
Route::post ('updatePassword', 'SettingsController@updatePassword')->name('updatePassword');


//Route::get ('toolkit_view/{slug}', 'ToolkitContentController@index');
//Route::post ('load_content', 'ToolkitContentController@load_content'); //newly created
//Route::post ('load_question', 'ToolkitContentController@load_question'); //newly created


Route::get ('toolkit', 'ToolkitController@index');

Route::get ('about_us', 'AboutUsController@index');

Route::get ('book_workshop', 'BookController@index');
Route::post ('book_workshop', 'BookController@book_workshop')->name('book_workshop');

Route::get ('jobs/{type?}', 'AllJobsController@index');
Route::get ('job_applications/{id}/{type?}', 'AllJobsController@job_applications');
Route::get ('search_filter_jobs', 'AllJobsController@search_filter');
Route::post ('verify_applied_job', 'AllJobsController@verify_applied_job');
Route::post ('submit_cover_letter', 'AllJobsController@submit_cover_letter');
Route::post ('add_job', 'AllJobsController@add_job')->name('add_job');
Route::get ('job_detail/{job_id}', 'AllJobsController@job_detail');
Route::post ('show_offer_letter', 'AllJobsController@show_offer_letter');
Route::post ('save_job', 'AllJobsController@save_job');
Route::post ('remove_saved_job', 'AllJobsController@remove_saved_job');
Route::get ('remove_job/{id}', 'AllJobsController@remove_job');
Route::get ('shortlisted/{id}', 'AllJobsController@shortlisted');
Route::get ('confirm_interview/{id}', 'AllJobsController@confirm_interview');


Route::post ('upload_picture', 'TeacherController@picture');

Auth::routes();


// SSLCOMMERZ Start
Route::get('/example1', 'SslCommerzPaymentController@exampleEasyCheckout');
Route::get('/example2', 'SslCommerzPaymentController@exampleHostedCheckout');

Route::post('/pay', 'SslCommerzPaymentController@index');
Route::post('/pay-via-ajax', 'SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'SslCommerzPaymentController@success');
Route::post('/fail', 'SslCommerzPaymentController@fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn');
//SSLCOMMERZ END

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// Route::get('unauthenticated',function(){
//     return response()->json(["code" =>-1, "msg" => "unauthenticated"]);
// })->name('api.unauthenticated');
Route::group(['namespace'=>'Api'],function(){


    Route::post('/login', 'UserController@createUser');    
    //authentication middleware
    Route::group(['middleware'=>['auth:sanctum']], function(){
        Route::any('/checkout','PayController@checkout');
        Route::any('/courseList','CourseController@courseList');
        Route::any('/recommendedCourseList','CourseController@recommendedCourseList');
        Route::any('/searchCourseList','CourseController@searchCourseList');
        Route::any('/courseDetail','CourseController@courseDetail');
        Route::any('/lessonList','LessonController@lessonList');
        Route::any('/lessonDetail','LessonController@lessonDetail');
        Route::any('/coursesBought','CourseController@coursesBought');
        //just for one item 
        Route::any('/courseBought','CourseController@courseBought');
        
        Route::any('/orderList','CourseController@orderList');
        //about author 
        Route::any('/courseAuthor','CourseController@courseAuthor');
        //getting all the list created by this author
        Route::any('/courseListAuthor','CourseController@courseListAuthor');
    });

    Route::any('/web_go_hooks','PayController@web_go_hooks');
});



<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'teacher'],function(){
    Route::any('/login','TeacherController@login' );
});
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
class CourseController extends Controller
{
    public function courseList(){
        try{
            $result = Course::select('name', 'thumbnail','lesson_num','price','id')->get();
        return response()->json([
                   'code' => 200,
                    'msg' => "My course list was successfully",
                    'data' => $result
                ],200);
        }catch(\Throwable $throw){
                    return response()->json([
                        'code' => 500,
                       'msg' => 'The Column does not exist or you do not have a syntax error' ,
                       'data' =>  $throw->getMessage()
                    ],500);
    }
}

// return all the recommended courses list
public function recommendedCourseList(){
    try{
        $result = Course::select('name', 'thumbnail','lesson_num','price','id')->where('recommended','=',1)->get();
    return response()->json([
               'code' => 200,
                'msg' => "My recommended course list is here",
                'data' => $result
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
}
}
public function searchCourseList(Request $request){


    $search = $request->search;
    try{
        $result = Course::select('name', 'thumbnail','lesson_num','price','id')
        ->where('name',"like",'%'.$search.'%')
        ->get();
    return response()->json([
               'code' => 200,
                'msg' => "My search course list is here",
                'data' => $result
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
}
}


    // return a course details
    public function courseDetail(Request $request){
    //course id
    $id = $request-> id;
    try{
        $result = Course::where('id','=',$id)->select(
            'id',
            'name', 
            //this is teacher's token
            //not the active user
            'user_token',
            'description',
            'price',
            'lesson_num',
            'video_length',
            'thumbnail',
            'price',
            'downloadable_res'
            )->first();
    
        return response()->json([
               'code' => 200,
                'msg' => "The course you bought was successfully",
                'data' => $result
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
}
}

public function courseBought(Request $request){
    
    try{

        $orderMap = [];
        $orderMap['course_id'] = $request->id;
        $orderMap['user_token'] = $request->user()->token;
        $orderMap['status'] = 1;
    
        // if the order has been placed before or not
        // so we need Order model/table
    
        $orderRes = Order::where( $orderMap)->first();
        if(!empty($orderRes)) {
            return response()->json([
                'code'=>200,
                'msg' =>'success',
                'data' =>"" 
            ]);
        }else {
            //item not bought
                return response()->json([
                    'code'=>200,
                    'msg' =>'failure',
                    'data' =>"" 
                ]);
        }
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
}

}


public function coursesBought(Request $request){
    //course id
    
    $user = $request->user();
    $result = Course::join('orders', 'courses.id','=', 'orders.course_id')
    ->select('courses.name', 'courses.thumbnail', 'courses.lesson_num' , 'courses.price','courses.id')
    ->where('orders.status', '=', 1)
    ->where('orders.user_token', '=', $user->token)->get();

    try{
        return response()->json([
               'code' => 200,
                'msg' => "My course detail is here",
                'data' => $result,
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
}
}


public function orderList(Request $request){
    //course id
    
    $user = $request->user();
    $result = Course::join('orders', 'courses.id','=', 'orders.course_id')
    ->select('courses.name', 'courses.thumbnail', 'courses.lesson_num' , 'courses.price','courses.id','orders.status',)
    // ->where('orders.status', '=', 1)

    ->where('orders.user_token', '=', $user->token)->get();

    try{
        return response()->json([
               'code' => 200,
                'msg' => "Your order list is here",
                'data' => $result,
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'The Column does not exist or you do not have a syntax error' ,
                   'data' =>  $throw->getMessage()
                ],500);
    }
}   
public function courseAuthor(Request $request){

    try{
        $token = $request->token;
        $result = DB:: table('admin_users')->where('token', $token)
        ->select('token','username as name','avatar', 'description', 'download')->first();
        if(!empty($result)){
            $result->avatar = 'uploads/'.$result->avatar;
        }
        
        
        return response()->json([
               'code' => 200,
                'msg' => "Your author is here",
                'data' => $result??json_decode('{}'),
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'Something is wrong with the author' ,
                   'data' =>  $throw->getMessage()
                ],500);
    }
}
public function courseListAuthor(Request $request){

    try{
        $token = $request->token;
        $result = Course::where('user_token','=', $token)
        ->select('name','thumbnail', 'lesson_num','price','id')->get();

        
        
        return response()->json([
               'code' => 200,
                'msg' => "Your author is here",
                'data' => $result??json_decode('{}'),
            ],200);
    }catch(\Throwable $throw){
                return response()->json([
                    'code' => 500,
                   'msg' => 'Something is wrong with the course list author' ,
                   'data' =>  $throw->getMessage()
                ],500);
    }
}
    
}

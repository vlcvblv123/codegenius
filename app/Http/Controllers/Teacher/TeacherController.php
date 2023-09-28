<?php


namespace App\Http\Controllers\Teacher;
use App\Models\AdminUser;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{     
    public function login(Request $request){
    try{
        $validateUser = Validator::make($request->all(), 
        [
           'username' => 'required',
           'password' => 'required|min:6'
       ]);

       if($validateUser->fails()){
           return response()->json([
               'state' => false,
               'messge' => 'validation error',
               'errors' => $validateUser->errors()
           ], 401);
       }
       // validated will have all user fields values
       // we can save in the database
       $validated = $validateUser-> validated();
       $map = [];
       $map['username'] = $validated['username'];

       
       $user = AdminUser::where($map)->first();
       if(empty($user->id)){
        return response()->json(['code'=>400, 'data'=>'','msg'=>'user does not exist'],400);
       }
       if(!Hash::check($validated['password'],$user->password)){
        return response()->json(['code'=>403, 'data'=>'','msg'=>'you are not authorized'],400);
       }
       $accessToken =$user->createToken(uniqid())->plainTextToken;
       $user->access_token = $accessToken;
       return response()->json(['code'=>200, 'data'=>$user,'msg'=>'user found'],200);
    
    }catch (\Throwable $th) {
        return response()->json([
            'state' => false,
            'messge' => $th->getMessage()
        ], 500);
    }
    //
    }
}

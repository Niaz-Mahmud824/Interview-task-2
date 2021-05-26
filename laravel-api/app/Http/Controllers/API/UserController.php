<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Profile;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    //
    public $successStatus = 200;
    /**
    * Register api
    *
    * @return \Illuminate\Http\Response
    */
   public function register(Request $request)
   {
       $validator = Validator::make($request->all(), [
           'name' => 'required',
           'email' => 'required|email',
           'password' => 'required',
           'c_password' => 'required|same:password',
       ]);
if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
       }
$input = $request->all();
       $input['password'] = bcrypt($input['password']);
       $user = User::create($input);
       $success['token'] =  $user->createToken('MyApp')-> accessToken;
       $success['name'] =  $user->name;
return response()->json(['success'=>$success], $this-> successStatus);
   }
   /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this-> successStatus);
    }
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json(['success' => $success], $this-> successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }

    }
    //Show all users
    public function index()
    {
        $test= User::all();

        return response(['Data'=>$test]);

    }
    //Add user with assigning role
    public function add(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'


        ]);
        User::create([
        'name'=>$request->name,
        'email'=>$request->email,
       'password' => Hash::make($request->password),
        'role_id'=>$request->role_id
        ]);

           $test= User::all();

        return response(['Data'=>$test]);
    }

    //Show single user details
    public function singleUser(Request $request) {
        $user= User::find($request->id);
        if(!$user) {
            return response(['message' => 'User not found for the provided info']);
        }

        return response(['message' => 'request successful', 'user' => $user]);
    }
    //Update User and changes role from user
    public function updateUser(Request $request)
    {
        $user = User::find($request->user()->id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->role_id=$request->role_id;
        $user->update();
        return response()->json(['data'=>$user]);
    }

}

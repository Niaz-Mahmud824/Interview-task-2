<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;

class ProfileController extends Controller
{
    public function createProfile(Request $request)
    {
        Profile::create([
            'user_id'=>$request->user_id,
            'education'=>$request->education,
            'age'=>$request->age,
           'address' => $request->address

            ]);

               $test= Profile::all();

            return response(['Data'=>$test]);
    }

    public function singleProfile(Request $request) {
        $profile= Profile::find($request->id);
        if(!$profile) {
            return response(['message' => 'User not found for the provided info']);
        }

        return response(['message' => 'request successful', 'user' => $profile]);
    }
}

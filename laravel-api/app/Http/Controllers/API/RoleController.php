<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Role;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    public function test(Request $request)
    {
        $this->validate($request,[
            'name'=>'required'

        ]);
        Role::create([
        'name'=>$request->name
        ]);
        session()->flash('success', 'Role created successfull');
           $test= Role::all();

        return response(['Data'=>$test]);
    }
}

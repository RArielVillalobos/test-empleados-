<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Role;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    //
    public function index(){
        return view('pages.user.index');
    }

    public function usersJson(){
        $users=User::all()->load('role');
        return ['users'=>$users];

    }

    public function selectRole(){
        $roles=Role::all();

        return ['roles'=>$roles];
    }
    public function store(Request $request){
        $this->authorize('create',User::class);
        $password=bcrypt($request->password);
        $request->merge(['password'=>$password]);
       $user=User::create($request->input());
        if($user->role_id==2){
            $employee=new Employee();
            $employee->user_id=$user->id;
            $employee->save();

        }




    }

    public function update(Request $request){
        $user=User::find($request->id);
        $this->authorize('update',$user);
        $user->name=$request->name;
        $user->password=bcrypt($request->password);
        $user->email=$request->email;
        //$user->role_id=$request->role_id;
        $user->update();
        //return $request->all();

    }

    public function delete(Request $request){
        $user=User::find($request->id);
        $this->authorize('update',$user);
        /*if($user->employee!=null){
            $user->employee->delete();


        }*/

        $user->delete();


    }
}

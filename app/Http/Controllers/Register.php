<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base as Base;
use App\Models\Tabel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Register extends Base
{
    public function register(Request $request)
    {
        $input = $request->all();
        $validateor = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validateor->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'error',
            ]);
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('badkend8')->accessToken;
        $success['name'] = $user->name;
        // return $this->sendResponse($success, 'Register Successfully');
        return response()->json([
            'status' => true,
            'token' => $success['token'],
            'message' => 'Register Succssfully',
            'username' => $success['name'],
        ]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validateor = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validateor->fails()) {
            return response()->json([
                'status' => 'ft',
                'message' => 'error',
            ]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            if (($request->countryside) && ($request->street)) {
                $id = User::find($user->id);
                $id->countryside = $request->countryside;
                $id->street = $request->street;
                $id->save();
            }
            $success['token'] = $user->createToken('backend')->accessToken;
            $success['name'] = $user->name;
            $success['role'] = $user->role;
            $success['id'] = $user->id;
            return response()->json([
                'token' => $success['token'],
                'message' => 'login successfully',
                'status' => true,
                'user_id' => $success['id'],
                'username' => $success['name'],
                'role' => $success['role'],
            ]);

            //return $this->sendResponse($success, 'Login Successfully');
        } else {
            return response()->json([
                'status' => false,
                'message' => 'UnAuthorised',
            ]);
            // return $this->sendError('please check your auth ', ['error' => 'unauthorised']);
        }
    }

    public function login_remotely(Request $request)
    {
        $input = $request->all();
        $validateor = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
            'street' => 'required',
            'countryside' => 'required',
        ]);
        if ($validateor->fails()) {
            return response()->json([
                'status' => 'ft',
                'message' => 'error',
            ]);
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            if (($request->countryside) && ($request->street)) {
                $id = User::find($user->id);
                $id->countryside = $request->countryside;
                $id->street = $request->street;
                $id->save();
            }
            $success['token'] = $user->createToken('backend')->accessToken;
            $success['name'] = $user->name;
            $success['role'] = $user->role;
            $success['id'] = $user->id;
            return response()->json([
                'token' => $success['token'],
                'message' => 'login successfully',
                'status' => true,
                'user_id' => $success['id'],
                'username' => $success['name'],
                'role' => $success['role'],
            ]);

            //return $this->sendResponse($success, 'Login Successfully');
        } else {
            return response()->json([
                'status' => false,
                'message' => 'UnAuthorised',
            ]);
            // return $this->sendError('please check your auth ', ['error' => 'unauthorised']);
        }
    }
    public function logout(Request $request)
    {
        $user = Auth::id();
        $tabel_id = Tabel::select('id')->where('user_id', $user)->value('id');
        $tabel = Tabel::find($tabel_id);
        $tabel->status = 'free';
        $tabel->save();
        $request->user()->Token()->delete();

        return response()->json([
            'message' => 'Logged out',
            'status' => true,
        ]);
    }
    public function logoutadmin(Request $request)
    {
        $request->user()->Token()->delete();

        return response()->json([
            'message' => 'Logged out',
            'status' => true,
        ]);
    }
    public function alluser()
    {
        $user = User::all();
        return response()->json(['status' => true,
            'user' => $user]);
    }
    public function edituser(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::class::make($input, [
            'role' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'password Must Be Required Or Must Be Invalid']);
        }
        $user = User::find($id);
        if (Hash::check($input['password'], $user->password)) {
            $user->role = $input['role'];
            $user->save();
            return response()->json(['status' => true, 'message' => 'updated successfully']);
        } else {
            return response()->json(['status' => false]);
        }

    }
    public function get_user($id)
    {
        $user = User::find($id);
        return response()->json(
            ['status' => true,
                'user' => $user]
        );
    }
    public function get_email($user_id)
    {
        $email = User::select('email')->where('id', $user_id)->value('email');
        $role = User::select('role')->where('id', $user_id)->value('role');
        return response()->json([
            'status' => true,
            'email' => $email,
            'role' => $role,
        ]);
    }
    public function add_user(Request $request)
    {
        $validateor = Validator::class::make($request->all(), [
            'name' => 'required',
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validateor->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Error Validation',
                'error' => $validateor->errors(),
            ]);
        }
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $input['password'];
        $user->save();
        return response()->json([
            'status' => true,
            'message' => 'Created User Done !!',
        ]);
    }
    public function get_roll()
    {
        $user = User::select('id', 'role')->groupBy('role')->get();
        return response()->json([
            'status' => true,
            'roll' => $user,
        ]);
    }
    public function edit_notify(Request $request)
    {
        $input = $request->all();
        User::where('id', $input['user_id'])->update([
            'notify' => 1,
        ]);
    }
    public function update_chef()
    {
        User::where('roll', 3)->update([
            'notify' => 1,
        ]);
        return response()->json([
            'status' => true,
        ]);
    }
    public function get_chef_notify()
    {
        $u = User::where('role', 3)->where('notify', 1)->get();
        if ($u) {
            return response()->json([
                'status' => true,

            ]);
        } else {
            return response()->json([
                'status' => false,
            ]);
        }
    }
}

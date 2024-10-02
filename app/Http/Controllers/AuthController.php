<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogedUsers;
use Illuminate\Container\Attributes\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class AuthController extends Controller
{
    //===========================REGISTRATION PAGE================================//
    public function start()
    {
        $requests = LogedUsers::all();
        $logeedUser = LogedUsers::where('role', session()->get('role'))->get();
        if (session()->has('user_id')) {
            if(session()->get('role') == 'user'){
                return redirect('/user-requests');
            }elseif(session()->get('role') == 'manager'){
                return view('registration', compact('requests'))->with('loggedUser', $logeedUser);
            }
            elseif(session()->get('role') == 'storageman'){
                return redirect('/index');
            }
        }else{
        return view('login');
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:logedusers',
            'password' => 'required',
            'role' => 'required|in:user,manager,storageman'
        ]);

        $user = new LogedUsers();
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Registration successful']);
    }
    public function getUser(Request $request)
    {
        $user = LogedUsers::find($request->user_id);
        $arr = [
            'user_id' => $user->id,
            'usernameedit' => $user->username,
            'roleedit' => $user->role,
        ];
        return ($arr);
    }

    public function updateUser(Request $request)
    {
        $user_id = $request->user_id;
        $user = LogedUsers::where('id', $user_id);

        // $data = $request->except('_token', 'user_id');
        // $user->update($request->except('_token', 'user_id'));
        // $user->username = $request->usernameedit;
        // $user->role = $request->roleedit;

        // dd($request);
        $data = [
            'username' => $request->usernameedit,

            'role' => $request->roleedit,
        ];


        $user->update($data);



        return response()->json(['success' => true, 'message' => 'User updated successfully']);
    }
       
    public function deleteUser($user_id)
    {

        $user = LogedUsers::where('id', $user_id);

        if ($user) {
            $user->delete($user_id);
            return redirect()->back()->with('status', 'user deleted Successfully');
        }

        return redirect()->back()->with('status', 'Error: User not found');
    }


    //===========================LOGIN PAGE================================//
    public function restart()
    {
        if (session()->has('user_id')) {
            if(session()->get('role') == 'user'){
                return redirect('/user-requests');
            }elseif(session()->get('role') == 'manager'){
                return redirect('/manager-requests');
            }
            elseif(session()->get('role') == 'storageman'){
                return redirect('/index');
            }
        }else{
            return view('login');
        }
        
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = LogedUsers::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Login success, store the user's ID in the session
            session()->put(['user_id' => $user->id, 'role' => $user->role]);
            
            // $userId = session()->get('user_id');
            // dd($userId);
            // Login success, return the user's role for routing
            return response()->json(['success' => true, 'role' => $user->role]);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

    public function logout() {
        session()->forget('user_id');
        session()->forget('role');

        
        
        return redirect('/login');
    }
    
}

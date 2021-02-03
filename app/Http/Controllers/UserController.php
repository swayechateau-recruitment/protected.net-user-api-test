<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function create(Request $request)
    {
        $user = new User;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        // set user name if supplied otherwise generate one
        if($request->input('username')) {
           $user->username = $request->input('username'); 
        } else {
            $i=0;
            $found = true;
            $username = substr($user->first_name, 0, 15);
            while($found){
                if($i > 0){
                    $username = $username.$i;
                }
                if(app('db')->table('users')->where('username',$username)->first()){
                   $i++;
                } else {
                    $found= false;
                }
            }
            $user->username = $username;
        }
        
        $user->save();
        return response()->json($user, 201);
    }
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user, 200);
        }
        return response()->json(['error' => [
            "code" => 404,
            "message" => "This user has left the galatic empire... if you catch my meaning ( ͡⚆ ͜ʖ ͡⚆)☞"
        ]], 404);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            if ($request->input('first_name')) {
                $user->first_name = $request->input('first_name');
            }
            if ($request->input('last_name')) {
                $user->last_name = $request->input('last_name');
            }
            return response()->json($user, 201);
        }
        return response()->json(['error' => [
            "code" => 404,
            "message" => "This user has left the galatic empire... if you catch my meaning ( ͡⚆ ͜ʖ ͡⚆)☞"
        ]], 404);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $message = [
            "code" => 410,
            "message" => "User has been disposed of ¬_¬"
        ];
        return response()->json($message, 410);
    }

    public function toggleDarkMode($id)
    {

        $user = User::find($id);
        if ($user) {

            $user->dark_mode = !$user->dark_mode;
            $user->save();
        }
        $message = "So, you are one of those light mode coders ¬_¬!";
        if ($user->dark_mode) {
            $message = "Welcome to the Darkside my child! ^_^";
        }

        return response()->json([
            "dark_mode" => $user->dark_mode,
            "message" => $message
        ], 201);

        return response()->json(['error' => [
            "code" => 404,
            "message" => "This user has left the galatic empire... if you catch my meaning ( ͡⚆ ͜ʖ ͡⚆)☞"
        ]], 404);
    }
}

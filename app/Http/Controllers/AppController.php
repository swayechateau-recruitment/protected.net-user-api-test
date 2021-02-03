<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AppController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=> 'index']);
    }

    public function install(Request $request)
    {
        try {
            app('db')->connection();
        } catch (\Exception $e) {
            return response()->json([
                "error" => [
                    "code"=> 500, 
                    "message" => 'oh no! - Something went wrong with the database connection!',
                    "exception" => $e
                ]
            ], 500);
        }

        // check if no tables found or reinstall requested
        if($request->input('reinstall') || !app('db')->select('SHOW TABLES')) {
            // run install
            Artisan::call('migrate:fresh --seed');
            return response()->json(['installed' => true,'message' => 'yes mate get in - setup ran successfully'], 201);
        }
        
        return response()->json(['installed' => false,'message' => 'App already installed or database already populated!'], 200);
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        if($q){
            $results = app('db')->table('users')
            ->where('username', 'like', "%{$q}%")
            ->orWhere('first_name', 'like', "%{$q}%")
            ->orWhere('last_name', 'like', "%{$q}%")
            ->get();
            return response()->json([
                'search_term'=> $q,
                'results' => $results,
                'total' => count($results)
            ], 200);
        }
        
        return response()->json(['message' => 'please define a query']);
    }
}

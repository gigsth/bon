<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Contact;
use Validator;

Class UserController extends Controller{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user) {
        
        $user = User::find($user);
        return response()->json($user, 200);
    }     
    
    public function store(Request $request) {
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email'=> 'required'
        ]);

        if($validator->fails()) {

            $response = array('response' => $validator->messages(), 'success' => false);
            return response()->json($response, 400);
        } else {

            //Create user
            $user           = new User;
            $user->name     = $request->input('name');
            $user->email    = $request->input('email');
            $user->save();

            return response()->json($user, 201);
        }
    } 
    
    public function update(Request $request, $user) {

        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]); 

        if($validator->fails()) {

            $response = array('response' => $validator->message(), 'success' => false);
            return response()->json($response, 400);
        } else {

            $user           = User::find($user);
            $user->name     = $request->input('name');
            $user->email    = $request->input('email');
            $user->save();

            return response()->json($user, 201);
        }
    }

    public function destroy($user) {
        
        $user = User::find($user);
        $user->delete();

        return response()->json(null, 204);
    }
   
}
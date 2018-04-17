<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Contact;
use App\User;
use Validator;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::all();
        return response()->json($contacts, 200);
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($contact)
    {
        $user = Contact::find($contact);
        return response()->json($user, 200);
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return response()->json($response, 400);
        } else {
            //Create contact
            $contact = new Contact;
            $contact->mobile = $request->input('mobile');
            $contact->name   = $request->input('name');
            $contact->user_id= $request->input('user_id');
            $contact->save();

            return response()->json($contact, 201);
        }
    }   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$contact)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $request->all(), 'success' => false);
            return response()->json($response, 400);
        } else {
            //Update contact
            $contact         = Contact::find($contact);
            $contact->mobile    = $request->input('mobile');
            $contact->name      = $request->input('name');
            $contact->user_id   = $request->input('user_id');
            $contact->save();

            return response()->json($request->all(), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contact)
    {
        //Delete Contact
        $contact = Contact::find($contact);
        $contact->delete();

        return response()->json(null ,204);
    }
}

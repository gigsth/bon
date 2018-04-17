<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Contact;
use App\User;
use Validator;

class UserContactsController extends Controller
{
    public function index($user)
    {
        $userContact =  User::find($user)->contacts;
        return response()->json($userContact, 200);
    }

    public function show($user, $contact)
    {
        $userContact = DB::table('users')
                            ->leftJoin('contacts', 'users.id', '=', 'contacts.user_id')
                            ->where('users.id', $user)
                            ->where('contacts.id', $contact)
                            ->get();
        return response()->json($userContact, 200);
    }

    public function store(Request $request, $user)
    {
        $validator = Validator::make($request->all(), [
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
            $contact->user_id= $user;
            $contact->save();

            return response()->json($contact, 201);
        }
    }

    public function update(Request $request, $user, $contact)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required'
        ]);

        $userContact = DB::table('users')
                        ->leftJoin('contacts', 'users.id', '=', 'contacts.user_id')
                        ->where('users.id', $user)
                        ->where('contacts.id', $contact)
                        ->get();

        if($validator->fails()) {
            
            $response = array('response' => $validator->messages(), 'success' => false);
            return response()->json($response ,400);
        } 
        else if($userContact->isEmpty()) {

            $response = array('response' => 'User or Contact not found', 'success'=>false);
            return response()->json($response, 400);
        }
        else { 

            $contact         = Contact::find($contact);         
            $contact->mobile = $request->input('mobile');
            $contact->name   = $request->input('name');
            $contact->user_id= $user;
            $contact->save();

            return response()->json($contact, 201);
        }
    }

    public function destroy($user, $contact)
    {
                   
        //Delete Contact
        $contact = Contact::find($contact);
        $contact->delete();

        return response()->json(null ,204);
        
    }
}

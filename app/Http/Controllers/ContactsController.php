<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contacts;
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
        $contacts = Contacts::all();
        return response()->json($contacts);
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
            return $response;
        } else {
            //Create contact
            $contact = new Contacts;
            $contact->mobile = $request->input('mobile');
            $contact->name   = $request->input('name');
            $contact->save();

            return response()->json($contact);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contacts::find($id);
        return response()->json($contact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return $response;
        } else {
            //Create contact
            $contact = new Contacts;
            $contact->mobile = $request->input('mobile');
            $contact->name   = $request->input('name');
            $contact->save();

            return response()->json($contact);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required'
        ]);

        if($validator->fails()){
            $response = array('response' => $validator->messages(), 'success' => false);
            return $response;
        } else {
            //Update contact
            $contact = Contacts::find($id);
            $contact->mobile = $request->input('mobile');
            $contact->name   = $request->input('name');
            $contact->save();

            return response()->json($contact);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete Contact
        $contact = Contacts::find($id);
        $contact->delete();

        $response = array('response' => 'Contact deleted', 'success' => true);
        return $response;
    }
}

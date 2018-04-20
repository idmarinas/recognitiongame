<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;
use RecognitionGame\Models\Contact;

class ContactController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 3);
        return view('pages/contact');
    }

    public function submitForm(Request $request) {
        $data = $request->all();
        $contact = new Contact();
        $contact->email = $request[0];
        $contact->subject = $request[1];
        $contact->message = $request[2];
        $contact->date =  now();
        $contact->save();
        return response([]);
    }
}
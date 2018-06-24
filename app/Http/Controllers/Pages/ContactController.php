<?php 
namespace RecognitionGame\Http\Controllers\Pages;

use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RecognitionGame\Models\Contact;

class ContactController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 3);
        return view('pages/contact');
    }

    public function init(Request $request) {
        return response([
            MasterController::databaseinfo_Init_Static(),
            MasterController::greeting_Init_Static(),
            MasterController::proposal_Init_Static(),
            MasterController::quickgame_Init_Static(),
            MasterController::webpagetext_FromDB_Static(
                [ 1001, 39, 55, 56, 57, 59, 43, 44, 60]
            )
        ]);
    }

    public function submitForm(Request $request) {
        $contact = new Contact();
        $contact->fill($request->all());
        $contact->date =  now();
        $contact->save();
        return response([]);
    }
}
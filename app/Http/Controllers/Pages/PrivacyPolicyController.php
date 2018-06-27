<?php 
namespace RecognitionGame\Http\Controllers\Pages;

use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 2);
        return view('pages/privacypolicy');
    }

    public function init(Request $request) {
        return response([
            MasterController::databaseinfo_Init_Static(),
            MasterController::proposal_Init_Static(),
            MasterController::quickgame_Init_Static(),
            MasterController::webpagetext_FromDB_Static([ 1003, 130 ])
        ]);
    }
}
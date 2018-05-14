<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;

class ThemesTopicsController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 4);
        return view('pages/themestopics');
    }
    
    public function init(Request $request) {
        return response([
            MasterController::databaseinfo_Init_Static(),
            MasterController::greeting_Init_Static(),
            MasterController::proposal_Init_Static(),
            MasterController::quickgame_Init_Static(),
            [
                MasterController::webpagetext_FromDB_Static([1055, 1056, 1057]),
                MasterController::mainthemethemetopic_FromDB_Static($request->all())
            ],
            MasterController::webpagetext_FromDB_Static([ 1003 ])
        ]);
    }
}
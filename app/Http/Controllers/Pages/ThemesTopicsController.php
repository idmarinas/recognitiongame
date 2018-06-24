<?php 
namespace RecognitionGame\Http\Controllers\Pages;

use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
                MasterController::webpagetext_FromDB_Static([1051, 1052]),
                MasterController::themesTopics_FromDB_Static($request->all())
            ],
            MasterController::webpagetext_FromDB_Static([ 1002 ])
        ]);
    }
}
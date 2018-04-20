<?php 

namespace RecognitionGame\Http\Controllers\Errors;
use RecognitionGame\Http\Controllers\Controller;

class Error404Controller extends Controller {
 
    public function index() {
        view()->share('share_pageID', 1000);
        return view('errorpages/error404');
    }
}
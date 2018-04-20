<?php 

namespace RecognitionGame\Http\Controllers\Pages;
use RecognitionGame\Http\Controllers\Controller;
 
class IndexController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 1);
        return view('pages/index');
    }
}
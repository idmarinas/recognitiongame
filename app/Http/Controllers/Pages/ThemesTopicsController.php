<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;

class ThemesTopicsController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 4);
        return view('pages/themestopics');
    }
}
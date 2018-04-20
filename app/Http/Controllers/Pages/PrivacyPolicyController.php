<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;

class PrivacyPolicyController extends Controller {
 
    public function index() {
        view()->share('share_pageID', 2);
        return view('pages/privacypolicy');
    }
}
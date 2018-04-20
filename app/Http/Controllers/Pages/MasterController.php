<?php 

namespace RecognitionGame\Http\Controllers\Pages;
use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RecognitionGame\Models\Webpagetext;
 
class MasterController extends Controller {
 
    public function changelang(\Illuminate\Http\Request $request) {
        session(['rg_lang'=>$request['lang']]);
        return redirect($request['route']);
    }

    public function webpagetextFromDB(Request $request) {
        $ids = $request->all();
        $back_value=[];
        foreach($ids as $id){
            array_push($back_value,Webpagetext::where('id',$id)->pluck('text_'.session('rg_lang'))->first());
        }
        return response($back_value);
    }
}
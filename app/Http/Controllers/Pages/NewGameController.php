<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
 
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;
use RecognitionGame\Http\Controllers\Pages\MasterController;

use RecognitionGame\Models\Topic;
use RecognitionGame\Models\Image;

class NewGameController extends Controller {
 
    public function index($sessionData_Random = null ) {
        if (!session()->has('rg_newgame_'.$sessionData_Random))
            return redirect('index');
        view()->share('share_pageID', 5);
        view()->share('share_sessionData_Random', $sessionData_Random);
        return view('pages/newgame');
    }    


    public function init(Request $request) {
        return response(
            [
                MasterController::webpagetext_FromDB_Static([27, 28, 29, 24, 16, 17]),
                MasterController::webpagetext_FromDB_Static([31, 63, 64, 35, 6, 7, 36]),
                NewGameController::currentGame_Data_Static($request->all())
            ]
        );
    }

    public function currentGame_Data(Request $request) {
        return response($this->currentGame_Data_Static($request->all()));
    }

    public static function currentGame_Data_Static($input_Array) {
        $session_Array = session('rg_newgame_'.$input_Array[1]);
        switch ($input_Array[0]){
            case -2:
                $session_Array[3] = [$session_Array[3][0]+1, -1, $session_Array[3][2], $session_Array[3][3]];
            break;
            case -1:
            
            break;
            default:
                $topic_Array = $session_Array[2][$session_Array[3][0]-1];
                if ($input_Array[0] == $topic_Array['image_ID'] )
                    $session_Array[3][2] = $session_Array[3][2] + 1;
                $session_Array[3] = [$session_Array[3][0], $input_Array[0], $session_Array[3][2], $session_Array[3][3]];
            break;            
        }
        session(['rg_newgame_'.$input_Array[1] => $session_Array]);
        $topic_Array = $session_Array[2][$session_Array[3][0]-1];
        for($i = 0; $i< count($session_Array[2][$session_Array[3][0]-1]['images']); $i++){
            $topic_Array['images'][$i] = [ 
                'id' => $session_Array[2][$session_Array[3][0]-1]['images'][$i], 
                'name' => Image::find($session_Array[2][$session_Array[3][0]-1]['images'][$i])->getAttribute('name_'.session('rg_lang'))];
        };
        $topic_Array['topic_Question'] = MasterController::questionCompose_Static($topic_Array['topic_ID']);
        return [
            $session_Array[0],
            $session_Array[1],
            $topic_Array,
            $session_Array[3],
            MasterController::topicPath_GetStatic( Topic::find($topic_Array['topic_ID'])->getAttribute('theme') ),
        ];
    }

}
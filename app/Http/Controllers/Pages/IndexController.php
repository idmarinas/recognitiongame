<?php 

namespace RecognitionGame\Http\Controllers\Pages;
use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use RecognitionGame\Http\Controllers\Pages\MasterController;
use RecognitionGame\Models\Image;
use RecognitionGame\Models\Topic;

class IndexController extends Controller {
 
    public function index(Request $request) {
        view()->share('share_pageID', 1);
        view()->share('share_proposal_Data', $request->query('proposal_Data'));
        return view('pages/index');
    }
    public static function  compareASCII($a, $b) {
        $at = iconv('UTF-8', 'ASCII//TRANSLIT', $a);
        $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b);
        return strcmp($at, $bt);
    }
    
    public function init(Request $request) {
        return response([
            MasterController::databaseinfo_Init_Static(),
            MasterController::greeting_Init_Static(),
            MasterController::proposal_Init_Static(),
            MasterController::quickgame_Init_Static(),
            // gametypeRadio_Items (0-4), enablehungarianSlideToggle_Text (5)
            // webpageText (6-14)            
            MasterController::webpagetext_FromDB_Static(
                [   120, 121, 122, 123, 124,
                    115, 
                    11, 23, -1, 1050, 37, 24, 25, 26, 2000
                ]),
            session('rg_lang'),
            MasterController::themesTopicsOfTheme_Static(1, 0, session('rg_lang')=='hu', false),
            IndexController::imageCount_FromDB_Static([
                session('rg_lang')=='hu',
                [1050, 0, ""],
                false
            ])
        ]);
    }

    public function imageCount_FromDB(Request $request) {
        return response($this->imageCount_FromDB_Static($request->all()));
    }

    public static function imageCount_FromDB_Static($input_Array){ 
        $topicID_Array = [];
        switch ($input_Array[1][0]){
            case 1050: case 1051:
                $topicID_Array = MasterController::themesTopicsOfTheme_Static(0, $input_Array[1][1], $input_Array[0], $input_Array[2]);
                break;
            case 1052:
                array_push($topicID_Array,$input_Array[1][1]);
                break;
        }
        $imageCount = DB::table('topic')->select(DB::raw('sum(image_to - image_from + 1) as count'))->whereIn('id', $topicID_Array)->pluck('count')->first();
        return $imageCount;
    }

    public function startNewGame(Request $request) {
        $gameProperties_Array['gametype'] = $request->all()[0];
        $gameProperties_Array['enablehungarian'] = $request->all()[1];
        $gameProperties_Array['selectedDTT'] = $request->all()[2];
        $sessionData_Random = rand();
        $predrawQuestion_Array = [];
        // Pre-draw questiontype and topicID
        $topicUsedPlace_Array = [];      
        $possibleTopic_Array1 = [];
        $possibleTopic_Array2 = [];
        switch ($gameProperties_Array['selectedDTT'][0]){
            case 1050: case 1051:
                $topicIDs_String1 = MasterController::themesTopicsOfTheme_Static(0, $gameProperties_Array['selectedDTT'][1], $gameProperties_Array['enablehungarian'], false);
                $topicIDs_String1 = implode(',',$topicIDs_String1);
                $possibleTopic_Array1 = DB::select("select id, image_from, image_to from topic where id in (".$topicIDs_String1.")");
                $topicIDs_String2 = MasterController::themesTopicsOfTheme_Static(0, $gameProperties_Array['selectedDTT'][1], $gameProperties_Array['enablehungarian'], true);
                if ($topicIDs_String2){
                    $topicIDs_String2 = implode(',',$topicIDs_String2);
                    $possibleTopic_Array2 = DB::select("select id, image_from, image_to from topic where id in (".$topicIDs_String2.")");
                }else
                    $possibleTopic_Array2 = [];
            break;
            case 1052:
                $topicIDs_String1 = $gameProperties_Array['selectedDTT'][1];
                $possibleTopic_Array1 = DB::select("select id, image_from, image_to from topic where id in (".$topicIDs_String1.")");
                if (Topic::find($gameProperties_Array['selectedDTT'][1])->getAttribute('oddoneout')>-1){
                    $possibleTopic_Array2 = DB::select("select id, image_from, image_to from topic where id = ".$gameProperties_Array['selectedDTT'][1].";");
                }else
                    $possibleTopic_Array2 = [];
            break;
        };
        for($i=0;$i<$request->all()[3];$i++){
            $questiontype = $gameProperties_Array['gametype'];
            if ($gameProperties_Array['gametype']==0) $questiontype = rand(1,4);
            $possibleTopic_Array = [];
            if ($questiontype != 4)
                $possibleTopic_Array = $possibleTopic_Array1;
            else{
                if (count($possibleTopic_Array2)>0)
                    $possibleTopic_Array = $possibleTopic_Array2;
                else{
                    $questiontype = rand(1,3);
                    $possibleTopic_Array = $possibleTopic_Array1;
                }
            }
            // Collect Topic IDs
            $topicID_TMP=-1;
            do{
                $freeImage = true;
                $index_TMP = rand(0,count($possibleTopic_Array)-1);
                $topicID_TMP = $possibleTopic_Array[$index_TMP]->id;
                if (array_key_exists((string)$topicID_TMP,$topicUsedPlace_Array)){
                    if ($possibleTopic_Array[$index_TMP]->image_to - $possibleTopic_Array[$index_TMP]->image_from+1>$topicUsedPlace_Array[(string)$topicID_TMP]){
                        $topicUsedPlace_Array[(string)$topicID_TMP]++;
                        $freeImage = false;
                    }else
                        $freeImage = true;
                }else{
                    $topicUsedPlace_Array[(string)$topicID_TMP] = 1;
                    $freeImage = false;
                }
            } while ($freeImage);
            array_push($predrawQuestion_Array, 
                array( 
                    'questiontype' => $questiontype,
                    'topic_ID' => $topicID_TMP
                ) 
            );
        }
        session(['rg_newgame_'.$sessionData_Random => [
            $gameProperties_Array, 
            NewGameController::drawNextQuestion_Static($predrawQuestion_Array[0]['topic_ID'], $predrawQuestion_Array[0]['questiontype'], []),
            [1, -1, 0, $request->all()[3]], // question_NR, answered, goodAnswer_Count, maxQuestion_NR
            $predrawQuestion_Array
        ]]);
        return response(['newgame', $sessionData_Random]); 
    }
}
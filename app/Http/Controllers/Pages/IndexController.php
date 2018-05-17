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

    public function init(Request $request) {
        return response([
            MasterController::databaseinfo_Init_Static(),
            MasterController::greeting_Init_Static(),
            MasterController::proposal_Init_Static(),
            MasterController::quickgame_Init_Static(),
            // gametypeRadio_Items (0-2), enablehungarianSlideToggle_Text (3)
            // imageCount_Text (4-8), webpageText (9-17)            
            MasterController::webpagetext_FromDB_Static(
                [   120, 121, 122, 
                    115, 
                    18, 22, 19, 20, 21,
                    11, 23, 1055, 1054, 37, 24, 25, 26, 2000
                ]),
            session('rg_lang'),
            MasterController::mainthemethemetopic_FromDB_Static([1055]),
            MasterController::mainthemethemetopic_FromDB_Static([1055, 1056, 1057]),
            IndexController::imageCount_FromDB_Static([
                session('rg_lang')=='hu',
                [1054, 0, ""]
            ])
        ]);
    }

    public function imageCount_FromDB(Request $request) {
        return response($this->imageCount_FromDB_Static($request->all()));
    }

    public static function imageCount_FromDB_Static($input_Array){ 
        $topicID_Array = [];
        switch ($input_Array[1][0]){
            case 1054: case 1055: case 1056:
                $topicID_Array = MasterController::getTopicsThemesOfTheme_Static(0, $input_Array[1][1], $input_Array[0]);
                break;
            case 1057:
                array_push($topicID_Array,$input_Array[1][1]);
                break;
        }
        $imageCount = DB::table('topic')->select(DB::raw('sum(image_to - image_from + 1) as count'))->whereIn('id', $topicID_Array)->pluck('count')->first();
        return $imageCount;
    }

    public function startNewGame(Request $request) {
        $gameProperties_Array['enablehungarian'] = $request->all()[1];
        $gameProperties_Array['gametype'] = $request->all()[0];
        $gameProperties_Array['selectedDMTT'] = $request->all()[2];
        $sessionData_Random = rand();
        // Draw only topics
        $answers_Topic = [];
        $topicID_Array = "";
        switch ($gameProperties_Array['selectedDMTT'][0]){
            case 1054: case 1055: case 1056:
                $topicID_Array = MasterController::getTopicsThemesOfTheme_Static(0, $gameProperties_Array['selectedDMTT'][1], $gameProperties_Array['enablehungarian']);
                $topicID_Array = implode(',',$topicID_Array);
                break;
            case 1057:
                $topicID_Array = Topic::where('id',$gameProperties_Array['selectedDMTT'][1])->pluck('id')->first();
                break;
        }
        $possibleTopic_Array = DB::select("select id, image_from, image_to, source from topic where id in (".$topicID_Array.")");
        $questionPlaceCount_Array = [];
        for($i=0;$i<$request->all()[3];$i++){
            // Check free image in that topic
            $topic_Place=-1;
            do{
                $freeImage = true;
                $topic_Place = rand(0,count($possibleTopic_Array)-1);
                if (array_key_exists($topic_Place,$questionPlaceCount_Array)){
                    if ($possibleTopic_Array[$topic_Place]->image_to - $possibleTopic_Array[$topic_Place]->image_from+1>$questionPlaceCount_Array[(string)$topic_Place]){
                        $questionPlaceCount_Array[(string)$topic_Place]=$questionPlaceCount_Array[(string)$topic_Place]+1;
                        $freeImage = false;
                    }else
                        $freeImage = true;
                }else{
                    $questionPlaceCount_Array[(string)$topic_Place] = 1;
                    $freeImage = false;
                }
            } while ($freeImage);
            array_push($answers_Topic, $possibleTopic_Array[$topic_Place]->id );
        }
        session(['rg_newgame_'.$sessionData_Random => [
            $gameProperties_Array, 
            NewGameController::drawNextQuestion_Static($answers_Topic[0], [], $gameProperties_Array['gametype']),            
            [1, -1, 0, $request->all()[3]], // question_NR, answered, goodAnswer_Count, maxQuestion_NR
            [],
            $answers_Topic
        ]]);
        return response(['newgame', $sessionData_Random]); 
    }
}
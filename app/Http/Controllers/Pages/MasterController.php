<?php 

namespace RecognitionGame\Http\Controllers\Pages;
use RecognitionGame\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use RecognitionGame\Models\Webpagetext;
use RecognitionGame\Models\Theme;
use RecognitionGame\Models\Topic;
use RecognitionGame\Models\Image;
 
class MasterController extends Controller {
 
    public function changelang(\Illuminate\Http\Request $request) {
        session(['rg_lang'=>$request['lang']]);
        return redirect($request['route']);
    }

/************************************** Databaseinfo **********************************/

    public static function databaseinfo_Init_Static() {
        return  [                    
                    [   Theme::where('parent',0)->count(),
                        Theme::where('parent', '<>', 0)->count(),
                        Topic::count(),
                        Image::count()   ],
                    MasterController::webpagetext_FromDB_Static([ 8, 1055, 1056, 1057, 9, 17, 16 ]),
                ];
    }

/**************************************** Greeting ************************************/

    public static function greeting_Init_Static() {
        return  MasterController::webpagetext_FromDB_Static([ 12, 13, 14, 15 ]);
    }

/********************************** Mainthemethemetopic *******************************/

public function mainthemethemetopic_FromDB(Request $request) {
    return response($this->mainthemethemetopic_FromDB_Static($request->all()));
}

public static function mainthemethemetopic_FromDB_Static($input_Array) {
    $back_Array=[];
    if (in_array(1054, $input_Array)){
        $tmp_Array = Theme::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
        foreach ($tmp_Array as $item)
            array_push($back_Array,array('id' => "1054;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
    }
    if (in_array(1055, $input_Array)){
        $tmp_Array =Theme::where('parent',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
        foreach ($tmp_Array as $item)
            array_push($back_Array,array('id' => "1055;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
    }
    if (in_array(1056, $input_Array)){
        $tmp_Array = Theme::where('parent','<>',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
        foreach ($tmp_Array as $item)
            array_push($back_Array,array('id' => "1056;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
    }
    if (in_array(1057, $input_Array)){
        $tmp_Array = Topic::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
        foreach ($tmp_Array as $item)
            array_push($back_Array,array('id' => "1057;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
    }
    if (count($input_Array)>0)
        usort($back_Array, function($a,$b) {return strnatcasecmp($a['text'],$b['text']);});
    return $back_Array;
}

/**************************************** Proposal ************************************/

    public static function proposal_Init_Static() {
        return  [
                    MasterController::webpagetext_FromDB_Static([ 1055, 1056, 1057, 67, 66, 10 ]),
                    MasterController::proposal_FromDB_Static()
                ];
    }

    public function proposalRefresh_FromDB(Request $request) {
        return response($this->proposal_FromDB_Static());
    }

    public static function proposal_FromDB_Static(){
        $mainthemeCount = Theme::where('parent',0)->count();
        $maintheme_TMP = Theme::where('parent',0)->get(['id','name_'.session('rg_lang')])->get(rand(0,$mainthemeCount-1));
        $maintheme =    array(
                            'id' => '1055;'.$maintheme_TMP['id'].';'.$maintheme_TMP['name_'.session('rg_lang')],
                            'text' => $maintheme_TMP['name_'.session('rg_lang')]
                        );
        $themeCount = Theme::where('parent','<>',0)->count();
        $theme_TMP = Theme::where('parent','<>',0)->get(['id','name_'.session('rg_lang')])->get(rand(0,$themeCount-1));
        $theme =    array(
                            'id' => '1056;'.$theme_TMP['id'].';'.$theme_TMP['name_'.session('rg_lang')],
                            'text' => $theme_TMP['name_'.session('rg_lang')]
                        );
        $topicCount = Topic::count()-3;
        $topic_TMP = Topic::get(['id','name_'.session('rg_lang')])->get(rand(0,$topicCount-1));
        $topic =    array(
                            'id' => '1057;'.$topic_TMP['id'].';'.$theme_TMP['name_'.session('rg_lang')],
                            'text' => $topic_TMP['name_'.session('rg_lang')]
                        );
        $lastTopics_TMP = Topic::orderBy('id','desc')->take(3)->get(['id','name_'.session('rg_lang')]);
        $lastTopic = [];
        foreach ($lastTopics_TMP as $item)
            array_push($lastTopic,
                array(
                    'id' => '1057;'.$item['id'].';'.$item['name_'.session('rg_lang')],
                    'text' => $item['name_'.session('rg_lang')]
                )
            );
        
        return  [   $maintheme,    
                    $theme,
                    $topic,                    
                    $lastTopic[0],
                    $lastTopic[1],
                    $lastTopic[2]   ];
    }


/**************************************** Quickgame ***********************************/

    public static function quickgame_Init_Static() {
        return  [
                    MasterController::webpagetext_FromDB_Static([ 63, 64, 6, 7, 65, 38 ]),
                    MasterController::quickgame_FromDB_Static()
                ];
    }

    public function quickgameRefresh_FromDB(Request $request) {
        return response($this->quickgame_FromDB_Static());
    }

    public static function quickgame_FromDB_Static(){  
        $topic_Count = Topic::count();
        $topic = Topic::all()->get(rand(0,$topic_Count-1));
        $image_Count = rand(2,$topic['image_to']-$topic['image_from'] + 1 > 10? 10 : $topic['image_to']-$topic['image_from'] + 1);
        $possibleAnswerID_Array = [];
        for($i=0;$i<$image_Count;$i++){
            $id=-1;
            do{
                $exists=false;
                $id = rand($topic->image_from, $topic->image_to);
                if(in_array($id, $possibleAnswerID_Array)) $exists = true;
            } while ($exists);
            $possibleAnswerID_Array[$i] = $id;
        }
        $correctAnswer_ID = $possibleAnswerID_Array[rand(0,$image_Count-1)];
        $answerArray_TMP = Image::whereIn('id',$possibleAnswerID_Array)->inRandomOrder()->get();
        $answer_Array = [];
        foreach($answerArray_TMP as $item)
            array_push($answer_Array,
                array(
                    'id' => $item['id'],
                    'text' => $item['name_'.session('rg_lang')]
                )
            );
        $bigImage = get_headers("http://www.felismerojatek.hu/kepek_big/".$topic['id']."/".($correctAnswer_ID-$topic['image_from']+1).".png");
        $bigImage_Exists = stripos($bigImage[0],"200 OK") ? true : false;
        return [    $topic,
                    $answer_Array,
                    $correctAnswer_ID,
                    MasterController::questionCompose_Static($topic->id),
                    $bigImage_Exists    ];
    }

/*************************************** Webpagetext ***********************************/

    public function webpagetext_FromDB(Request $request) {
        return response([$this->webpagetext_FromDB_Static($request->all())]);
    }

    public static function webpagetext_FromDB_Static( $ids ){
        $back_value=[];
        foreach($ids as $id){
            array_push($back_value,Webpagetext::where('id',$id)->pluck('name_'.session('rg_lang'))->first());
        }
        return $back_value;
    }

/********************************** Log the answers ************************************/
    public function answerLog_ToDB(Request $request) {
        return response($this->answerLog_ToDB_Static($request->all()));
    }

    public static function answerLog_ToDB_Static($input_Array){ 
        Image::find($input_Array[0])->increment('answer_total', 1);
        Image::find($input_Array[0])->increment('answer_good', $input_Array[1] ? 1 : 0);
        return [];
    }

/************************************ Topic path **************************************/

    public function topicPath(Request $request) {  
        if ($request->all()[0]==1056)
            return response([$this->topicPath_GetStatic($request->all()[1])]);
        else{
            $theme_ID = Topic::find($request->all()[1])->getAttribute('theme');
            return response([$this->topicPath_GetStatic($theme_ID)]);
        }
    }

    public static function topicPath_GetStatic( int $id ){
        $parent = 
            Theme::where('id', $id)->get(['parent','name_'.session('rg_lang')])->first();
        if ($parent['parent'] == 0)
            return [array('id' => $id, 'text' => $parent['name_'.session('rg_lang')])];
        $back_Array = array_merge(
            MasterController::topicPath_GetStatic($parent['parent']), 
            [array('id' => $id, 'text' => $parent['name_'.session('rg_lang')])]
        );
        return $back_Array;
    }

/*************************** All topics, themes of a theme *****************************/

    public function topicsThemesOfTheme(Request $request) {  
        return response([$this->getTopicsThemesOfTheme_Static(1, $request->all()[0], $request->all()[1])]);
    }

    public static function getTopicsThemesOfTheme_Static( int $type, int $parent, bool $enablehungarian){
        // 0 - Topic IDs [ 1, 5, 8, 14 ... ]
        // 1 - Themes and Topics ID and Name [{id: 1, name: 'Geography'},{id: 2, name: 'Art'}]
        $back_Array = [];
        $subThemes = 
            Theme::where('parent', $parent)->get(['id', 'name_'.session('rg_lang'), 'parent']);
        $subThemesTopics =[];
        foreach ($subThemes as $item){
            $subThemesTopics_TMP = MasterController::getTopicsThemesOfTheme_Static($type, $item['id'], $enablehungarian) ;
            if (count($subThemesTopics_TMP)>0){
                $subThemesTopics = array_merge($subThemesTopics, $subThemesTopics_TMP);
                if ((count($subThemesTopics)>0)&&($type == 1))
                    array_push($back_Array, array( 'id' => '1056;'.$item['id'], 'name' => $item['name_'.session('rg_lang')], 'parent' => $parent));
            }
        }
        if (count($subThemesTopics)>0){
            $back_Array = array_merge($back_Array, $subThemesTopics);
        }
        $subTopics = 
            Topic::where('theme', $parent)->whereIn('hungarian', [false, $enablehungarian])->get(['id', 'name_'.session('rg_lang')]);
        if ($subTopics->count())
            foreach ($subTopics as $item){
                if ($type==0)
                    array_push($back_Array, $item['id']);
                if ($type==1)
                    array_push($back_Array, array( 'id' => '1057;'.$item['id'], 'name' => $item['name_'.session('rg_lang')], 'parent' => $parent));
            }
        return $back_Array;
    }

/******************************** Compose the question text ****************************/

    public static function questionCompose_Static($topic_ID){
        $back_String = '';
        $topic_String = Topic::find($topic_ID)->getAttribute('name_'.session('rg_lang'));
        if (session('rg_lang')=='hu')
            $back_String = "Melyik <i>".$topic_String."</i> látható a képen?";
        else
            $back_String = "Which <i>".$topic_String."</i> is this image?";
        return $back_String;
    }
}
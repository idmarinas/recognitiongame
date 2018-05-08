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

    public function webpagetextFromDB(Request $request) {
        $ids = $request->all();
        $back_value=[];
        foreach($ids as $id){
            array_push($back_value,Webpagetext::where('id',$id)->pluck('name_'.session('rg_lang'))->first());
        }
        return response([$back_value,session('rg_lang')]);
    }

    public function mainthemethemetopicFromDB(Request $request) {
        $backArray=[];
        switch ($request->all()[0]){
            case 1054:
                array_push($backArray,Theme::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]));
            break;
            case 1055:
                array_push($backArray,Theme::where('parent',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]));
            break;
            case 1056:
                array_push($backArray,Theme::where('parent','<>',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]));
            break;
            case 1057:
                array_push($backArray,Topic::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]));
            break;
        }
        return response([$backArray[0],session('rg_lang')]);
    }

    public function proposalFromDB(Request $request) {
        $mainthemeCount = Theme::where('parent',0)->count();
        $themeCount = Theme::where('parent','<>',0)->count();
        $topicCount = Topic::count()-3;
        $lastTopics = Topic::orderBy('id','desc')->take(3)->get(['id','name_'.session('rg_lang')]);
        return response([
            [
                Theme::where('parent',0)->get(['id','name_'.session('rg_lang')])->get(rand(0,$mainthemeCount-1)),    
                Theme::where('parent','<>',0)->get(['id','name_'.session('rg_lang')])->get(rand(0,$themeCount-1)),
                Topic::get(['id','name_'.session('rg_lang')])->get(rand(0,$topicCount-1)),
                $lastTopics[0],
                $lastTopics[1],
                $lastTopics[2]
            ],
            session('rg_lang')
        ]);
    }

    public function quickgameFromDB(Request $request) {        
        $topicCount = Topic::count();
        $topic = Topic::all()->get(rand(0,$topicCount-1));
        $possibleAnswersCount = rand(2,$topic->image_to-$topic->image_from + 1 > 10? 10 : $topic->image_to-$topic->image_from + 1);
        $possibleAnswerIDArray = [];
        for($i=0;$i<$possibleAnswersCount;$i++){
            $id=-1;
            do{
                $exists=false;
                $id = rand($topic->image_from, $topic->image_to);
                if(in_array($id, $possibleAnswerIDArray)) $exists = true;
            } while ($exists);
            $possibleAnswerIDArray[$i] = $id;
        }
        $correctAnswerID = $possibleAnswerIDArray[rand(0,$possibleAnswersCount-1)];
        $possibleAnswerArray = Image::whereIn('id',$possibleAnswerIDArray)->inRandomOrder()->get();
        return response([
            $topic,
            $possibleAnswerArray,
            $correctAnswerID,
            session('rg_lang'),
            $this->question_Compose_Static($topic->id)
        ]);
    }

    public function answerLogToDB(Request $request) {
        Image::find($request->all()[0])->increment('image_total', 1);
        Image::find($request->all()[0])->increment('answer_good', $request->all()[1] ? 1 : 0);
    }

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
            $subThemesTopics = array_merge($subThemesTopics, MasterController::getTopicsThemesOfTheme_Static($type, $item['id'], $enablehungarian) );
            if ((count($subThemesTopics)>0)&&($type == 1))
                array_push($back_Array, array( 'id' => '1056;'.$item['id'], 'name' => $item['name_'.session('rg_lang')], 'parent' => $parent));
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

    public static function question_Compose_Static($topic_ID){
        $back_String = '';
        $topic_String = Topic::find($topic_ID)->getAttribute('name_'.session('rg_lang'));
        if (session('rg_lang')=='hu')
            $back_String = "Melyik <i>".$topic_String."</i> látható a képen?";
        else
            $back_String = "Which <i>".$topic_String."</i> is this image?";
        return $back_String;
    }
}
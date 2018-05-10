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
        $back_Array=[];
        if (in_array(1054, $request->all())){
            $tmp_Array = Theme::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
            foreach ($tmp_Array as $item)
                array_push($back_Array,array('id' => "1054;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
        }
        if (in_array(1055, $request->all())){
            $tmp_Array =Theme::where('parent',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
            foreach ($tmp_Array as $item)
                array_push($back_Array,array('id' => "1055;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
        }
        if (in_array(1056, $request->all())){
            $tmp_Array = Theme::where('parent','<>',  0)->orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
            foreach ($tmp_Array as $item)
                array_push($back_Array,array('id' => "1056;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
        }
        if (in_array(1057, $request->all())){
            $tmp_Array = Topic::orderBy('name_'.session('rg_lang'))->get(['id','name_'.session('rg_lang')]);
            foreach ($tmp_Array as $item)
                array_push($back_Array,array('id' => "1057;".$item['id'] , 'text' => $item['name_'.session('rg_lang')] ));
        }
        if (count($request->all())>0)
            usort($back_Array, function($a,$b) {return strnatcasecmp($a['text'],$b['text']);});
        return response([$back_Array]);
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
                Topic::get(['id','name_'.session('rg_lang')])->get(rand(0,$topicCount-1))
            ],[
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
        $bigImage = get_headers("http://www.felismerojatek.hu/kepek_big/".$topic['id']."/".($correctAnswerID-$topic['image_from']+1).".png");
        $bigImage_Exists = stripos($bigImage[0],"200 OK") ? true : false;
        return response([
            $topic,
            $possibleAnswerArray,
            $correctAnswerID,
            session('rg_lang'),
            $this->question_Compose_Static($topic->id),
            $bigImage_Exists
        ]);
    }

    public function answerLogToDB(Request $request) {
        Image::find($request->all()[0])->increment('image_total', 1);
        Image::find($request->all()[0])->increment('answer_good', $request->all()[1] ? 1 : 0);
    }

    public function mainthemeOfThemeTopic(Request $request) {  
        if ($request->all()[0]==1056)
            return response([$this->mainthemeOfThemeTopic_GetStatic($request->all()[1])]);
        else{
            $theme_ID = Topic::find($request->all()[1])->getAttribute('theme');
            return response([$this->mainthemeOfThemeTopic_GetStatic($theme_ID)]);
        }
    }

    public static function mainthemeOfThemeTopic_GetStatic( int $id ){
        $parent_ID = 
            Theme::find($id)->getAttribute('parent');
        if ($parent_ID == 0)
            return [$id];
        $back_Array = array_merge(MasterController::mainthemeOfThemeTopic_GetStatic($parent_ID), [$id]);
        return $back_Array;
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
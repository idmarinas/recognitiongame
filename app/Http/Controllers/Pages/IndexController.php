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

    public function imageCountFromDB(Request $request) {  
        $topicID_Array = [];
        switch ($request->all()[1][0]){
            case 1054: case 1055: case 1056:
                $topicID_Array = MasterController::getTopicsThemesOfTheme_Static(0, $request->all()[1][1], $request->all()[0]);
                //$topicID_Array = implode(',',$topicID_Array);
                break;
            case 1057:
                array_push($topicID_Array,$request->all()[1][1]);
                break;
        }
        $imageCount = DB::table('topic')->select(DB::raw('sum(image_to - image_from + 1) as count'))->whereIn('id', $topicID_Array)->pluck('count')->first();
        return response([$imageCount]);
    }

    public function startNewGame(Request $request) {
        $gametype = $request->all()[0];
        $enablehungarian = $request->all()[1];
        $selectedDMTT = $request->all()[2];
        $maxnrquestion= $request->all()[3];
        $topicID_Array ="";
        switch ($selectedDMTT[0]){
            case 1054: case 1055: case 1056:
                $topicID_Array = MasterController::getTopicsThemesOfTheme_Static(0, $selectedDMTT[1], $enablehungarian);
                $topicID_Array = implode(',',$topicID_Array);
                break;
            case 1057:
                $topicID_Array = Topic::where('id',$selectedDMTT[1])->pluck('id')->first();
                break;
        }
        $topic_TmpArray = DB::select("select id, image_from, image_to, source from topic where id in (".$topicID_Array.")");
        $possibleTopic_Array = json_decode(json_encode($topic_TmpArray), True);
        $topics_Array = [];
        $questionPlaceCount_Array = [];
        for($i=0;$i<$maxnrquestion;$i++){
            // Check free image in that topic
            $topic_Place=-1;
            do{
                $freeImage = true;
                $topic_Place = rand(0,count($possibleTopic_Array)-1);
                if (array_key_exists($topic_Place,$questionPlaceCount_Array)){
                    if ($possibleTopic_Array[$topic_Place]['image_to']-$possibleTopic_Array[$topic_Place]['image_from']+1>$questionPlaceCount_Array[(string)$topic_Place]){
                        $questionPlaceCount_Array[(string)$topic_Place]=$questionPlaceCount_Array[(string)$topic_Place]+1;
                        $freeImage = false;
                    }else
                        $freeImage = true;
                }else{
                    $questionPlaceCount_Array[(string)$topic_Place] = 1;
                    $freeImage = false;
                }
            } while ($freeImage);
            // Draw an unused imagePlace
            $image_ID=-1;
            do{
                $image_Exists = false;
                $image_ID = rand($possibleTopic_Array[$topic_Place]['image_from'],$possibleTopic_Array[$topic_Place]['image_to']);
                foreach($topics_Array as $item)
                    if ($item['image_ID'] == $image_ID) $image_Exists=true;
            } while ($image_Exists);
            // Draw images
            $images = [];
            $images_Count = rand (2, $possibleTopic_Array[$topic_Place]['image_to']-$possibleTopic_Array[$topic_Place]['image_from']+1<10 ? $possibleTopic_Array[$topic_Place]['image_to']-$possibleTopic_Array[$topic_Place]['image_from']+1 : 10);
            for($j=0;$j<$images_Count-1;$j++){
                $image=-1;
                do{
                    $exists = false;
                    $image = rand ($possibleTopic_Array[$topic_Place]['image_from'],$possibleTopic_Array[$topic_Place]['image_to']);
                    if ((in_array($image,$images))||($image == $image_ID)) $exists=true;
                } while($exists);
                array_push($images, $image);
            }
            array_push($images, $image_ID);
            shuffle($images);
            $bigImages = [];
            foreach($images as $image){
                $bigImage = get_headers("http://www.felismerojatek.hu/kepek_big/".$possibleTopic_Array[$topic_Place]['id']."/".($image-$possibleTopic_Array[$topic_Place]['image_from']+1).".png");
                $bigImage_Exists = stripos($bigImage[0],"200 OK") ? '_big' : '';
                array_push($bigImages, $bigImage_Exists);
            }
            $topic_Array = [];
            $topic_Array['image_ID'] = $image_ID;
            $topic_Array['images'] = $images;
            $topic_Array['bigImages'] = $bigImages;
            $topic_Array['topic_ID'] = $possibleTopic_Array[$topic_Place]['id'];
            $topic_Array['topic_ImageFrom'] = $possibleTopic_Array[$topic_Place]['image_from'];
            $topic_Array['topic_Source'] = $possibleTopic_Array[$topic_Place]['source'];
            array_push($topics_Array, $topic_Array);
        };
        $sessionData_Random = rand();
        session(['rg_newgame_'.$sessionData_Random => [
            $gametype, 
            $selectedDMTT, 
            $topics_Array,            
            [1, -1, 0, $maxnrquestion] // question_NR, answered, goodAnswer_Count, maxQuestion_NR
        ]]);
        return response(['newgame', $sessionData_Random]); 
    }
}
<?php namespace RecognitionGame\Http\Controllers\Pages;
 

use RecognitionGame\Http\Controllers\Controller;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use RecognitionGame\Http\Requests;
use RecognitionGame\Http\Controllers\Pages\MasterController;
use Illuminate\Support\Facades\Log;

use RecognitionGame\Models\Image;
use RecognitionGame\Models\Imageage;
use RecognitionGame\Models\Topic;
use RecognitionGame\Models\Topicage;
use RecognitionGame\Models\Webpagetext;

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
                MasterController::webpagetext_FromDB_Static([
                    27, 28, 29, 23, 30, 120, 121, 122, 123, 124, 125,
                    68, 39, 69, 59, 43, 44, 57, 60,
                    63, 64, 35, 6, 7, 36, 31, 68, 41, 42, 18, 19, 20, 12]),
                NewGameController::currentGame_Data_Static($request->all())
            ]
        );
    }

    public function help_Change(Request $request){
        $session_Array = session('rg_newgame_'.$request->all()[0]);
        $session_Array[1]['help_ImagesExploded'] = $request->all()[1];
        $session_Array[1]['help_ZoomLevel'] = $request->all()[2];
        session(['rg_newgame_'.$request->all()[0] => $session_Array]);
        return response([]);
    }

    public function currentGame_Data(Request $request) {
        return response($this->currentGame_Data_Static($request->all()));
    }

    public static function currentGame_Data_Static($input_Array) {
        $session_Array = session('rg_newgame_'.$input_Array[1]);
        switch ($input_Array[0]){
            case -2:
                $session_Array[3][$session_Array[2][0]-1]['image_ID'] = $session_Array[1]['imageGood_ID'];
                $session_Array[2][0]++;
                $session_Array[2][1] = -1;
                $session_Array[1] = NewGameController::drawNextQuestion_Static($session_Array[3][$session_Array[2][0]-1]['topic_ID'], $session_Array[3][$session_Array[2][0]-1]['questiontype'], array_column($session_Array[3], 'image_ID') );
            break;
            case -1:
            break;
            default:
                $topic_Array = $session_Array[1];
                if ($topic_Array['questiontype']==5){
                    if ($input_Array[0] == $topic_Array['images'][0]['age'] ){
                        MasterController::answerLog_ToDB_Static([$topic_Array['imageGood_ID'], null, $topic_Array['questiontype'], $input_Array[0] ]);
                        $session_Array[2][2] = $session_Array[2][2] + 1;
                    }
                    MasterController::answerLog_ToDB_Static([$topic_Array['imageGood_ID'], null, $topic_Array['questiontype'], $input_Array[0]]);
                    $tmp_Imageage = Imageage::find($topic_Array['imageGood_ID']);
                    $backData = "---";
                    if ($tmp_Imageage['answer_sum']!=0) $backData = bcdiv($tmp_Imageage['answer_sum'],$tmp_Imageage['answer_total'],0);
                    $session_Array[1]['images'][0]['age_averageanswers'] = $backData;

                }else{
                    if ($input_Array[0] == $topic_Array['imageGood_ID'] ){
                        MasterController::answerLog_ToDB_Static([$topic_Array['imageGood_ID'], true, $topic_Array['questiontype'], null]);
                        $session_Array[2][2] = $session_Array[2][2] + 1;
                    }else
                        MasterController::answerLog_ToDB_Static([$topic_Array['imageGood_ID'], false, $topic_Array['questiontype'], null]);
                }
                $session_Array[2] = [$session_Array[2][0], $input_Array[0], $session_Array[2][2], $session_Array[2][3]];
                $session_Array[1]['help_ZoomLevel'] = 0;
            break;            
        }
        session(['rg_newgame_'.$input_Array[1] => $session_Array]);
        return $session_Array;
    }

    public static function drawNextQuestion_Static($topic_ID, $questiontype, $imageID_Array){
        $topic = Topic::find($topic_ID);
        // Draw an unused imagePlace
        $topic_Array = [];
        $topic_Array['questiontype'] = $questiontype;
        $topic_Array['help_ZoomLevel'] = $topic_Array['questiontype']==2 ? 2 : 0;
        $imageGood_ID=-1;
        if ($topic_Array['questiontype']!=4)
            do{
                $image_Exists = false;
                if (($topic_Array['questiontype']!=5))
                    $imageGood_ID = rand( $topic['image_from'] , $topic['image_to']);
                else{
                    $imageGood_ID = Imageage::where('topic', $topic_ID)->inRandomOrder()->get(['id'])->first()->getAttribute('id');
                }
                if (in_array($imageGood_ID, $imageID_Array)) $image_Exists=true;
            } while ($image_Exists);
        $images = [];
        $help_ImagesExploded = [];
        if (($topic_Array['questiontype']!=5)){
            // Draw other images
            $anotherImage_ID=-1;
            switch ($topic_Array['questiontype']){
                case 3:
                    do{
                        $anotherImage_Exists = false;
                        $anotherImage_ID = rand( $topic['image_from'] , $topic['image_to']);
                        if ($anotherImage_ID == $imageGood_ID) $anotherImage_Exists=true;
                    } while ($anotherImage_Exists);
                    array_push($images, array(
                        'image_ID' => $imageGood_ID, 
                        'text' => '',
                        'textAfterAnswered' => MasterController::answerFalseCompose_Static(Image::find($imageGood_ID)->getAttribute('name_'.session('rg_lang'))),
                        'topic_ID' => $topic_ID,
                        'topic_ImageFrom' => $topic['image_from']
                    ));
                    array_push($images, array(
                        'image_ID' => $anotherImage_ID, 
                        'text' => '',
                        'textAfterAnswered' => MasterController::answerFalseCompose_Static(Image::find($anotherImage_ID)->getAttribute('name_'.session('rg_lang'))),
                        'topic_ID' => $topic_ID,
                        'topic_ImageFrom' => $topic['image_from']
                    ));
                    if ( rand(0, 1) == 1 )
                        $images = array_replace($images,[$images[1], $images[0]]);    
                    $images[0]['textAfterAnswered'] = '';
                    if ($imageGood_ID == $images[0]['image_ID']) $images[1]['textAfterAnswered'] = '';
                    $images[0]['text'] = Webpagetext::find(150)->getAttribute('name_'.session('rg_lang'));
                    $images[1]['text'] = Webpagetext::find(151)->getAttribute('name_'.session('rg_lang'));
                break;
                case 4:
                    $possibleAnswerTopics_Array = Topic::where('oddoneout', Topic::find($topic_ID)->getAttribute('oddoneout'))->where('id','<>',$topic_ID)->get();
                    $index = rand (0, count($possibleAnswerTopics_Array)-1);
                    $topic_OddOneOut = $possibleAnswerTopics_Array[$index];
                    $imageGood_ID = rand ($topic_OddOneOut['image_from'],$topic_OddOneOut['image_to']);
                    array_push($images, array(
                        'image_ID' => $imageGood_ID, 
                        'text' => Image::find($imageGood_ID)->getAttribute('name_'.session('rg_lang')),
                        'topic_ID' => $topic_OddOneOut['id'],
                        'topic_ImageFrom' => $topic_OddOneOut['image_from'],
                        'topic_Text' => $topic_OddOneOut['name_'.session('rg_lang')]
                    ));
                    $topic_Answers = Topic::find($topic_ID);
                    $images_Count = rand (2, $topic_Answers['image_to'] - $topic_Answers['image_from'] + 1 < 10 ? $topic_Answers['image_to'] - $topic_Answers['image_from'] + 1 : 10);
                    for($j=0;$j<$images_Count-1;$j++){
                        $imageOther_ID=-1;
                        do{
                            $exists = false;
                            $imageOther_ID = rand ($topic_Answers['image_from'],$topic_Answers['image_to']);
                            foreach($images as $item)
                                if ($item['image_ID']==$imageOther_ID) $exists = true;
                        } while($exists);
                        array_push($images, array(
                            'image_ID' => $imageOther_ID, 
                            'text' => Image::find($imageOther_ID)->getAttribute('name_'.session('rg_lang')),
                            'topic_ID' => $topic_Answers['id'],
                            'topic_ImageFrom' => $topic_Answers['image_from'],
                            'topic_Text' => $topic_Answers['name_'.session('rg_lang')]
                        ));
                    }
                    $count_TMP =    ($images_Count>=3)&&($images_Count<=5) 
                                        ? 1 
                                        : (($images_Count>=6)&&($images_Count<=8) 
                                            ? 2 
                                            : ($images_Count>=9 ? 3 : 0));

                    for($i=0;$i<$count_TMP;$i++){
                        do{
                            $exists = false;
                            $image_Place = rand (0, $images_Count-1);
                            if ($imageGood_ID==$images[$image_Place]['image_ID']) $exists = true;
                            foreach($help_ImagesExploded as $item)
                                if (($item['image_ID'] == $images[$image_Place]['image_ID'])||($imageGood_ID==$images[$image_Place]['image_ID'])) $exists = true;
                        } while($exists);
                        array_push($help_ImagesExploded, array(
                            'image_ID' => $images[$image_Place]['image_ID'], 
                            'exploded' => false
                        ));
                    }
                    shuffle($images);
                break;
                default:
                    array_push($images, array(
                        'image_ID' => $imageGood_ID, 
                        'text' => Image::find($imageGood_ID)->getAttribute('name_'.session('rg_lang')),
                        'topic_ID' => $topic_ID,
                        'topic_ImageFrom' => $topic['image_from']
                    ));
                    $images_Count = rand (2, $topic['image_to'] - $topic['image_from'] + 1 < 10 ? $topic['image_to'] - $topic['image_from'] + 1 : 10);
                    for($j=0;$j<$images_Count-1;$j++){
                        $imageOther_ID=-1;
                        do{
                            $exists = false;
                            $imageOther_ID = rand ($topic['image_from'],$topic['image_to']);
                            foreach($images as $item)
                                if ($item['image_ID']==$imageOther_ID) $exists = true;
                        } while($exists);
                        array_push($images, array(
                            'image_ID' => $imageOther_ID, 
                            'text' => Image::find($imageOther_ID)->getAttribute('name_'.session('rg_lang')),
                            'topic_ID' => $topic_ID,
                            'topic_ImageFrom' => $topic['image_from'] 
                        ));
                    }
                    $count_TMP =    ($images_Count>=3)&&($images_Count<=5) 
                                        ? 1 
                                        : (($images_Count>=6)&&($images_Count<=8) 
                                            ? 2 
                                            : ($images_Count>=9 ? 3 : 0));
                    for($i=0;$i<$count_TMP;$i++){
                        do{
                            $exists = false;
                            $image_Place = rand (0, $images_Count-1);
                            if ($imageGood_ID==$images[$image_Place]['image_ID']) $exists = true;
                            foreach($help_ImagesExploded as $item)
                                if ($item['image_ID'] == $images[$image_Place]['image_ID']) $exists = true;
                        } while($exists);
                        array_push($help_ImagesExploded, array(
                            'image_ID' => $images[$image_Place]['image_ID'], 
                            'exploded' => false
                        ));
                    }
                    shuffle($images);
                break;
            }
            $bigImages = [];
            foreach($images as $key=>$image){
                $bigImage = get_headers("http://www.felismerojatek.hu/kepek_big/".$image['topic_ID']."/".($image['image_ID'] - $topic['image_from'] + 1).".png");
                $images[$key]['bigImage'] = stripos($bigImage[0],"200 OK") ? '_big' : '';
                if ($topic_Array['questiontype']==4)
                    $images[$key]['cssClass'] = 'game_button2';
                else
                    $images[$key]['cssClass'] = 'game_button1 button1_white';
            }
            $topic_TMP = Topic::where('id',$topic_ID)->get(['name_'.session('rg_lang'),'theme'])->first();
            $topic_Array['topic_Question'] = MasterController::questionCompose_Static($topic_ID, $topic_Array['questiontype'], $images[0]['image_ID'] == $anotherImage_ID ? $anotherImage_ID : $imageGood_ID);
            $topic_Array['topic_Source'] = $topic['source'];
        }else{
            $bigImage = get_headers("http://www.felismerojatek.hu/kepekage_big/".$topic_ID."/".$imageGood_ID.".png");
            array_push($images, array(
                'bigImage' => stripos($bigImage[0],"200 OK") ? '_big' : '',
                'image_ID' => $imageGood_ID, 
                'text' => '',
                'age' => Imageage::find($imageGood_ID)->getAttribute('age'),
                'topic_ID' => $topic_ID,
                'topic_ImageFrom' => -1
            ));
            $topic_TMP = Topicage::where('id',$topic_ID)->get(['name_'.session('rg_lang'),'theme'])->first();
            $topic_Array['topic_Question'] = MasterController::questionCompose_Static($topic_ID, $topic_Array['questiontype'], -1);
            $topic_Array['topic_Source'] = Imageage::where('id', $imageGood_ID)->first()->getAttribute('source');
        }
        $topicPath_Array = [array('id' => $topic_ID, 'text' => $topic_TMP['name_'.session('rg_lang')])];
        $topic_Array['topic_Path'] = array_merge( MasterController::topicPath_GetStatic($topic_TMP['theme']), $topicPath_Array );
        $topic_Array['imageGood_ID'] = $imageGood_ID;
        $topic_Array['images'] = $images;
        $topic_Array['help_ImagesExploded'] = $help_ImagesExploded;
        return $topic_Array;
    }
}
<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Topic;

class TableTopicSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableTopicDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['name_hu'] = substr_replace(fgets($myfile), "", -2);
             $item['name_en'] = substr_replace(fgets($myfile), "", -2);
             $item['theme'] = fgets($myfile);
             $item['source'] = substr_replace(fgets($myfile), "", -2);
             $item['image_from'] = fgets($myfile);
             $item['image_to'] = fgets($myfile);
             $item['hungarian'] = fgets($myfile);
             $item['oddoneout'] = fgets($myfile);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Topic::where('id',$item['id'])->exists()){
                Topic::insert($item);
            }else{
                $topic = Topic::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    $topic[$key] = $item[$key];
                $topic->save();
            }
        }
    }
}
?>
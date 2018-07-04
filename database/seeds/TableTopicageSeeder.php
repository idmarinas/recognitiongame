<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Topicage;

class TableTopicageSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableTopicageDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['name_hu'] = substr_replace(fgets($myfile), "", -2);
             $item['name_en'] = substr_replace(fgets($myfile), "", -2);
             $item['theme'] = fgets($myfile);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Topicage::where('id',$item['id'])->exists()){
                Topicage::insert($item);
            }else{
                $Topicage = Topicage::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    $Topicage[$key] = $item[$key];
                $Topicage->save();
            }
        }
    }
}
?>
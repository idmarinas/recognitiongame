<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Imageage;

class TableImageageSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableImageageDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['age'] = substr_replace(fgets($myfile), "", -2);
             $item['topic'] = fgets($myfile);
             $item['source'] = substr_replace(fgets($myfile), "", -2);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Imageage::where('id',$item['id'])->exists()){
                $item['answer_total'] = 0;
                $item['answer_sum'] = 0;
                Imageage::insert($item);
            }else{
                $answer = Imageage::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    if (!(($key=='answer_total') || ($key=='answer_sum'))) $answer[$key] = $item[$key];
                $answer->save();
            }
        }
    }
}
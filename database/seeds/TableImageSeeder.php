<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Image;

class TableImageSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableImageDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['name_hu'] = substr_replace(fgets($myfile), "", -2);
             $item['name_en'] = substr_replace(fgets($myfile), "", -2);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Image::where('id',$item['id'])->exists()){
                $item['answer_total'] = 0;
                $item['answer_good'] = 0;
                Image::insert($item);
            }else{
                $answer = Image::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    if (!(($key=='answer_total') || ($key=='answer_good'))) $answer[$key] = $item[$key];
                $answer->save();
            }
        }
    }
}
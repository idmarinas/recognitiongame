<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\DifficultyLevel;

class TableDifficultylevelSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableDifficultyLevelDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['range_start'] = substr_replace(fgets($myfile), "", -2);
             $item['range_end'] = substr_replace(fgets($myfile), "", -2);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!DifficultyLevel::where('id',$item['id'])->exists()){
                DifficultyLevel::insert($item);
            }else{
                $answer = DifficultyLevel::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    if (!(($key=='answer_total') || ($key=='answer_good'))) $answer[$key] = $item[$key];
                $answer->save();
            }
        }
    }
}
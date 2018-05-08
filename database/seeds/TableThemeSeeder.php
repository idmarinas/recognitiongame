<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Theme;

class TableThemeSeeder extends Seeder{
    
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableThemeDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['name_hu'] = substr_replace(fgets($myfile), "", -2);
             $item['name_en'] = substr_replace(fgets($myfile), "", -2);
             $item['parent'] = fgets($myfile);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Theme::where('id',$item['id'])->exists()){
                Theme::insert($item);
            }else{
                $theme = Theme::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    $theme[$key] = $item[$key];
                $theme->save();
            }
        }
    }
}
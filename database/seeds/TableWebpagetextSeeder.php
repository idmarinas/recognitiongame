<?php

use Illuminate\database\Seeder;

use RecognitionGame\Models\Webpagetext;

class TableWebpagetextSeeder extends Seeder{
    
    // 1000 - 1049: Menu titles
    // 1051 - 1059: Database, Main theme, theme, topic level texts
    public function run(){
        $dataArray=[];
        $myfile = fopen("database/seeds/TableWebpagetextDefaultData.txt", "r");
        while(!feof($myfile)) {
             $item['id'] = fgets($myfile);
             $item['name_hu'] = substr_replace(fgets($myfile), "", -2);
             $item['name_en'] = substr_replace(fgets($myfile), "", -2);
             array_push($dataArray,$item);
        }
        fclose($myfile);
        foreach($dataArray as $item){
            if(!Webpagetext::where('id',$item['id'])->exists()){
                Webpagetext::insert($item);
            }else{
                $webpagetext = Webpagetext::where('id',$item['id'])->first();
                foreach ($item as $key => $value)
                    $webpagetext[$key] = $item[$key];
                $webpagetext->save();
            }
        }
    }
}
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use RecognitionGame\Models\Webpagetext;

class TableWebpagetext extends Migration{

    public function up(){
        if (!Schema::hasTable('webpagetext')){
            Schema::create('webpagetext', function (Blueprint $table) {
                $table->increments('id');
                $table->text('name_hu');
                $table->text('name_en');
            });
        }
        
    }
    
    public function down(){
//        Schema::dropIfExists('webpagetext');
    }
}
?>
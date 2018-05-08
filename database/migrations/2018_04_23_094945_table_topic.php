<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableTopic extends Migration{

    public function up(){
        if (!Schema::hasTable('topic')){
            Schema::create('topic', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_hu', 100);
                $table->string('name_en', 100);
                $table->integer('theme');
                $table->string('source', 50)->nullable();
                $table->integer('image_from');
                $table->integer('image_to');
                $table->boolean('hungarian');
            });
        }
    }

    public function down(){
    //    Schema::dropIfExists('topic');
    }
}
?>
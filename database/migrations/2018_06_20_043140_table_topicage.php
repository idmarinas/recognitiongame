<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableTopicage extends Migration{

    public function up(){
        if (!Schema::hasTable('topicage')){
            Schema::create('topicage', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_hu', 100);
                $table->string('name_en', 100);
                $table->integer('theme');
            });
        }
    }

    public function down(){
    //    Schema::dropIfExists('topicage');
    }
}
?>
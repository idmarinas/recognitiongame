<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableImageage extends Migration{

    public function up(){
        if (!Schema::hasTable('imageage')){
            Schema::create('imageage', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('age');
                $table->integer('topic');
                $table->string('source', 50)->nullable();
                $table->integer('answer_total');
                $table->integer('answer_sum');
            });
        }
    }

    public function down(){
//        Schema::dropIfExists('imageage');
    }
}
?>
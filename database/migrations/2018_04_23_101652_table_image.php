<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableImage extends Migration{

    public function up(){
        if (!Schema::hasTable('image')){
            Schema::create('image', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_hu', 100);
                $table->string('name_en', 100);
                $table->integer('answer_total');
                $table->integer('answer_good');
            });
        }
    }

    public function down(){
//        Schema::dropIfExists('image');
    }
}
?>
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableDifficultylevel extends Migration{

    public function up(){
        if (!Schema::hasTable('difficultylevel')){
            Schema::create('difficultylevel', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('range_start');
                $table->integer('range_end');
            });
        }
    }

    public function down(){
//        Schema::dropIfExists('difficultylevel');
    }
}
?>
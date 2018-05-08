<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableTheme extends Migration{

    public function up(){
        if (!Schema::hasTable('theme')){
            Schema::create('theme', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name_hu', 50);
                $table->string('name_en', 50);
                $table->integer('parent');
            });
        }
    }

    public function down(){
//        Schema::dropIfExists('theme');
    }
}
?>
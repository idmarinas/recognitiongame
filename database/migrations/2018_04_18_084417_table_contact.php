<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use RecognitionGame\Models\Contact;

class TableContact extends Migration{

    public function up(){
        if (!Schema::hasTable('contact')){
            Schema::create('contact', function (Blueprint $table) {
                $table->increments('id');
                $table->string('email');
                $table->string('subject')->nullable();
                $table->text('message');
                $table->date('date');
            });
        }
        
    }
    
    public function down(){
        Schema::dropIfExists('contact');
    }
}
?>
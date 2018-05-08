<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    
    public function run(){
        $this->call([
            TableDifficultylevelSeeder::class, 
            TableImageSeeder::class, 
            TableThemeSeeder::class,
            TableTopicSeeder::class,
            TableWebpagetextSeeder::class
        ]);
    }
}

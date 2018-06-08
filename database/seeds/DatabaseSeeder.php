<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    
    public function run(){
        $this->call([
            TableImageSeeder::class, 
            TableThemeSeeder::class,
            TableTopicSeeder::class,
            TableWebpagetextSeeder::class
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{
    
    public function run(){
        $this->call([
            TableImageSeeder::class, 
            TableImageageSeeder::class, 
            TableThemeSeeder::class,
            TableTopicSeeder::class,
            TableTopicageSeeder::class,
            TableWebpagetextSeeder::class
        ]);
    }
}

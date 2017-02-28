<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UserSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(AchievementSeeder::class);
        $this->call(ScoreSeeder::class);
        
        //Unused. These seeds are inserted in ScoreSeeder
        //$this->call(RecordSeeder::class);
        //$this->call(ComponentSeeder::class); 
    }
}

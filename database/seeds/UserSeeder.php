<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
          array( 
            'name' => 'admin',
            'email' => '', 
            'password' => 'qwerty123', 
            'lang_pref' => 'en', 
            'role' => 'admin',
            'student_id' => null
          ));
        
        DB::table('users')->insert(
          array( 
            'name' => '',
            'email' => '', 
            'password' => '', 
            'lang_pref' => 'en', 
            'role' => 'student',
            'student_id' => null //some id
          ));
      
        DB::table('users')->insert(
          array( 
            'name' => '',
            'email' => '', 
            'password' => '', 
            'lang_pref' => 'zh', 
            'role' => 'student',
            'student_id' => null //some id
          ));
    }
}
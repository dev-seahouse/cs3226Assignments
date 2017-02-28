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
          'name' => 'bevin',
          'email' => 'bevinseetoh@hotmail.com', 
          'password' => bcrypt('qwerty123'), 
          'lang_pref' => 'en', 
          'role' => 'admin',
          'student_id' => null,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s')
        ));
      
      DB::table('users')->insert(
        array( 
          'name' => 'kenan',
          'email' => 'sayhi.kenan@gmail.com', 
          'password' => bcrypt('qwerty123'), 
          'lang_pref' => 'en', 
          'role' => 'admin',
          'student_id' => null,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s')
        ));
      
      DB::table('users')->insert(
        array( 
          'name' => 'vivian',
          'email' => 'vivian198912@gmail.com', 
          'password' => bcrypt('qwerty123'), 
          'lang_pref' => 'en', 
          'role' => 'admin',
          'student_id' => null,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s')
        ));
      
      DB::table('users')->insert(
        array( 
          'name' => 'larry',
          'email' => 'larry1285@gmail.com', 
          'password' => bcrypt('qwerty123'), 
          'lang_pref' => 'en', 
          'role' => 'admin',
          'student_id' => null,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s')
        ));
      
      DB::table('users')->insert(
        array( 
          'name' => 'shawn',
          'email' => 'shawnlimjq@hotmail.com', 
          'password' => bcrypt('qwerty123'), 
          'lang_pref' => 'en', 
          'role' => 'admin',
          'student_id' => null,
          'created_at' => date('Y-m-d H:m:s'),
          'updated_at' => date('Y-m-d H:m:s')
        ));
      
//        DB::table('users')->insert(
//          array( 
//            'name' => 'admin',
//            'email' => '', 
//            'password' => 'qwerty123', 
//            'lang_pref' => 'en', 
//            'role' => 'admin',
//            'student_id' => null
//          ));
        
//        DB::table('users')->insert(
//          array( 
//            'name' => '',
//            'email' => '', 
//            'password' => '', 
//            'lang_pref' => 'en', 
//            'role' => 'student',
//            'student_id' => null //some id
//          ));
//      
//        DB::table('users')->insert(
//          array( 
//            'name' => '',
//            'email' => '', 
//            'password' => '', 
//            'lang_pref' => 'zh', 
//            'role' => 'student',
//            'student_id' => null //some id
//          ));
    }
}
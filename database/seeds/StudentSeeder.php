<?php

use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = \Faker\Factory::create();
      
      $names = array(
          'Hitler', 'Kangaroo', 'Henry', 'Tom', 'Zeus', 'Lina', 'Pichu', 'Cloud', 'Tifa', 'Sephiroth',
          'Lightning', 'Panda', 'Husky', 'Jerry', 'Dora', 'ET', 'Snoopy', 'Munchkin', 'Gangster', 'Bear', 
          'Elf', 'Fox', 'Goldfish', 'Koi', 'Squidward', 'Spongebob', 'Patrick', 'Alucard', 'Kazuya', 'Heihachi', 
          'Jack', 'Drake', 'Zoro', 'Nami', 'Ace', 'Robin', 'Shanks', 'Buggy', 'Chopper', 'Brook', 
          'Franky', 'Sanji', 'Naruto', 'Sasuke', 'Itachi', 'Boruto', 'Ninja', 'Leonardo', 'Yodas', 'Smarty'
        );
      
      $countries = array(
          'AUS', 'CHN', 'GER', 'JPN', 'SGP'
        );
      
      for ($i = 0; $i < 50; $i++) {
        $uniqName = $names[$i];
        
        DB::table('students')->insert(
          array( 
            'nationality' => $faker->randomElement($array = $countries),
            'gender' => $faker->randomElement($array = array('Male', 'Female')),
            'profile_pic' => $uniqName, 
            'name' => $uniqName, 
            'nick' => $uniqName,
            'kattis' => $uniqName,
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
          ));
      }
    }
}

<?php

use Illuminate\Database\Seeder;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for ($i = 1; $i <= 50; $i++) {
        $studentId = $i;
        $randNum = rand(1, 8);
        
        $faker = \Faker\Factory::create();
        $values = array();
        for ($z = 0; $z < $randNum; $z++) {
          $values []= $faker->unique()->numberBetween(1, 8);
        }
        
        for ($j = 0; $j < $randNum; $j++) {
          DB::table('records')->insert(
          array( 
            'student_id' => $studentId,
            'achievement_id' => $values[$j], 
            'points' => 1, 
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
          ));
        }
      }
    }
}

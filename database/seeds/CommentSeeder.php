<?php

use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = \Faker\Factory::create();
      
      for ($i = 1; $i <= 50; $i++) {
        DB::table('comments')->insert(
          array(
            'student_id' => $i,
            'comment' => $faker->realText($maxNbChars = 200, $indexSize = 2),
            'created_at' => date('Y-m-d H:m:s'),
            'updated_at' => date('Y-m-d H:m:s')
          ));
      }
    }
}

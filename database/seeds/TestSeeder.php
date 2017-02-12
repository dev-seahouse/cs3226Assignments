<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 5; $i++) {
          App\Component::create([
              "student_id" => $i,
              "component_t_id" => $i+1
            ]);

        }
    }
}

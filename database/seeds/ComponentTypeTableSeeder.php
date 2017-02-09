<?php

use Illuminate\Database\Seeder;

class ComponentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $score_component_types = ['MC', 'TC', 'HW', 'BS', 'KS', 'AC'];
        foreach ($score_component_types as $c) {
            DB::table('component_t')->insert(['name' => $c]);
        }
    }
}

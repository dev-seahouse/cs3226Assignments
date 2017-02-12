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
            $comp_type = new App\ComponentType;
            $comp_type->name = $c;
            $comp_type->save();
        }
    }
}

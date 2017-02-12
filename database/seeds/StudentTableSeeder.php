<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Student::class, 50)->create()->each(function ($s) {
            // for each component type, create one component for the student
            $componentTypes = App\ComponentType::all();
            $componentTypes->each(function($t) use ($s){
                $component = factory(App\Component::class)->states($t_name = $t->name)->make();
                $scores = factory(App\Score::class,12)->states($t_name)->make();
                $s->components()->save($component);
                $counter = 0;
                $scores->each(function($score) use ($counter){
                    $score-> score_index = $counter++;
                });
                $component->scores()->saveMany($scores);
            });
        });
    }
}

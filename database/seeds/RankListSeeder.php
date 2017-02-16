<?php

use Illuminate\Database\Seeder;

class RankListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $this->call(AchievementSeeder::class);
        $component_types = array('MC', 'TC', 'HW', 'BS', 'KS', 'AC');
        // precondition: create achievements
        factory(App\Student::class, 50)->create()->each(function (App\Student $s) use ($component_types) {
            //1.create 6 components with student_id = $s->id
            foreach ($component_types as $component_type) {
                $component_model = factory(App\Component::class)->states($component_type)->make(); // make the model, don't save first
                // for each component type, generate scores with score factory defined for that component type
                $score_models = factory(App\Score::class, $this->get_number_of_scores_to_generate_for_component($component_type))->states($component_type)->make();
                // after generating scores, populate week index for each generated score for that component
                $s->components()->save($component_model);
                $week_counter = 0;
                $score_models->each(function($score_model) use (&$week_counter){
                    $score_model-> score_index = $week_counter++;
                });
                // inject component sums into component
                $component_model->component_sum = $score_models->sum('score');
                $component_model->scores()->saveMany($score_models);
                $s->components()->save($component_model);
            }
            //2.create 1 comment for student
            $comment_model = factory(App\Comment::class)->make();
            $s->comment()->save($comment_model); // save the comment belonging to the student
            //3.create random number of records between 0 - 5 with $student->id and $achievement->id
            // meaning each student will have 0 - 5 achievements
            // bug:not unique
           /* $records = factory(App\Record::class, mt_rand(0,5))->make();
            $s->records()->saveMany($records);*/
        });
        $this->call(RecordSeeder::class);
    }
    // only generate 2 scores if a score belong to MC , else generate 9 scores
    private function get_number_of_scores_to_generate_for_component($component_type){
        return $component_type == "MC" ? 2 : 9;
    }
}
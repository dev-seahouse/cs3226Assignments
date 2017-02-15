<?php

use Illuminate\Database\Seeder;

class ScoreSeeder extends Seeder
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
          $components = $this->generateComponents();
          
          for ($j = 0; $j < count($components['MC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 1, 
                'score_index' => $j, 
                'score' => $components['MC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
          
          for ($j = 0; $j < count($components['TC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 2, 
                'score_index' => $j, 
                'score' => $components['TC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
          
          for ($j = 0; $j < count($components['HW']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 3, 
                'score_index' => $j, 
                'score' => $components['HW'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
          
          for ($j = 0; $j < count($components['BS']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 4, 
                'score_index' => $j, 
                'score' => $components['BS'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
          
          for ($j = 0; $j < count($components['KS']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 5, 
                'score_index' => $j, 
                'score' => $components['KS'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
          
          for ($j = 0; $j < count($components['AC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component_id' => 6, 
                'score_index' => $j, 
                'score' => $components['AC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
          }
        }
    }
    
    private function generateComponents() {
      $faker = \Faker\Factory::create();
      
      $mc = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($mc, $faker->randomElement(
          $array = array('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','x.y')
        ));
      }
      
      $tc = array();
      for ($i = 0; $i < 2; $i++) {
        array_push($tc, $faker->randomElement(
          $array = array(
            '0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5',
            '5.0','5.5','6.0','6.5','7.0','7.5','8.0','8.5','9.0','9.5',
            '10','xy.z')
        ));
      }
      
      $hw = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($hw, $faker->randomElement(
          $array = array('0.0','0.5','1.0','1.5','x.y')
        ));
      }
      
      $bs = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($bs, $faker->randomElement(
          $array = array('0','1','x')
        ));
      }
      
      $ks = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($ks, $faker->randomElement(
          $array = array('0','1','x')
        ));
      }
      
      $ac = array();
      for ($i = 0; $i < 2; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1','x')
        ));
      }
      for ($i = 0; $i < 2; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1','2','3','x')
        ));
      }
      for ($i = 0; $i < 5; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1','x')
        ));
      }
      
      return array('MC' => $mc, 'TC' => $tc, 'HW' => $hw, 'BS' => $bs, 'KS' => $ks, 'AC' => $ac);
    }
}

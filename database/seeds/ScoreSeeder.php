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
          
          $mc = 0;
          for ($j = 0; $j < count($components['MC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'MC', 
                'week' => $j + 1, 
                'score' => $components['MC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['MC'][$j] != null) $mc += $components['MC'][$j];
          }
          
          $tc = 0;
          for ($j = 0; $j < count($components['TC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'TC', 
                'week' => $j + 1, 
                'score' => $components['TC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['TC'][$j] != null) $tc += $components['TC'][$j];
          }
          
          $hw = 0;
          for ($j = 0; $j < count($components['HW']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'HW', 
                'week' => $j + 1, 
                'score' => $components['HW'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['HW'][$j] != null) $hw += $components['HW'][$j];
          }
          
          $bs = 0;
          for ($j = 0; $j < count($components['BS']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'BS', 
                'week' => $j + 1, 
                'score' => $components['BS'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['BS'][$j] != null) $bs += $components['BS'][$j];
          }
          
          $ks = 0;
          for ($j = 0; $j < count($components['KS']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'KS', 
                'week' => $j + 1, 
                'score' => $components['KS'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['KS'][$j] != null) $ks += $components['KS'][$j];
          }
          
          $ac = 0;
          for ($j = 0; $j < count($components['AC']); $j++) {
            DB::table('scores')->insert(
              array( 
                'student_id' => $i,
                'component' => 'AC', 
                'week' => $j + 1, 
                'score' => $components['AC'][$j], 
                'created_at' => date('Y-m-d H:m:s'),
                'updated_at' => date('Y-m-d H:m:s')
              ));
            if ($components['AC'][$j] != null) $ac += $components['AC'][$j];
          }
          
          DB::table('components')->insert(
            array( 
              'student_id' => $i,
              'mc' => $mc,
              'tc' => $tc,
              'hw' => $hw,
              'bs' => $bs,
              'ks' => $ks,
              'ac' => $ac,
              'created_at' => date('Y-m-d H:m:s'),
              'updated_at' => date('Y-m-d H:m:s')
            ));
          
          //record seed for student achievements
          for ($j = 0; $j < count($components['AC']); $j++) {
            if ($components['AC'][$j] != null) {
              DB::table('records')->insert(
                array( 
                  'student_id' => $i,
                  'achievement_id' => $j + 1, 
                  'points' => $components['AC'][$j], 
                  'created_at' => date('Y-m-d H:m:s'),
                  'updated_at' => date('Y-m-d H:m:s')
                ));
            }
          }
       }
    }
    
    private function generateComponents() {
      $faker = \Faker\Factory::create();
      
      $mc = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($mc, $faker->randomElement(
          $array = array('0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0',null)
        ));
      }
      
      $tc = array();
      for ($i = 0; $i < 2; $i++) {
        array_push($tc, $faker->randomElement(
          $array = array(
            '0.0','0.5','1.0','1.5','2.0','2.5','3.0','3.5','4.0','4.5',
            '5.0','5.5','6.0','6.5','7.0','7.5','8.0','8.5','9.0','9.5',
            '10',null)
        ));
      }
      
      $hw = array();
      for ($i = 0; $i < 10; $i++) {
        array_push($hw, $faker->randomElement(
          $array = array('0.0','0.5','1.0','1.5',null)
        ));
      }
      
      $bs = array();
      for ($i = 0; $i < 9; $i++) {
        array_push($bs, $faker->randomElement(
          $array = array('0','1',null)
        ));
      }
      
      $ks = array();
      for ($i = 0; $i < 12; $i++) {
        array_push($ks, $faker->randomElement(
          $array = array('0','1',null)
        ));
      }
      
      $ac = array();
      for ($i = 0; $i < 2; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1',null)
        ));
      }
      for ($i = 0; $i < 2; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1','2','3',null)
        ));
      }
      for ($i = 0; $i < 4; $i++) {
        array_push($ac, $faker->randomElement(
          $array = array('0','1',null)
        ));
      }
      
      return array('MC' => $mc, 'TC' => $tc, 'HW' => $hw, 'BS' => $bs, 'KS' => $ks, 'AC' => $ac);
    }
}

<?php

use Illuminate\Database\Seeder;

class ComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = array(
          array('name' => 'MC'),
          array('name' => 'TC'),
          array('name' => 'HW'),
          array('name' => 'BS'),
          array('name' => 'KS'),
          array('name' => 'AC'),
          );
        
        foreach ($components as $component) { 
          DB::table('components')->insert(
            array( 
              'name' => $component['name'],
              'created_at' => date('Y-m-d H:m:s'),
              'updated_at' => date('Y-m-d H:m:s')
            ));
        }
    }
}

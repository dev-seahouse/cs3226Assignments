<?php

namespace App;
use \DB;

class DatabaseUtil {

  public static function get_last_updated(){
     $last_updated = DB::table('information_schema.tables')->where('table_schema','ranklist')->select('update_time')->limit(1)->get();
     return $last_updated;
  }
}



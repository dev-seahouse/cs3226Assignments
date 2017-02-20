<?php

namespace App;
use \DB;


class DatabaseUtil {

  public static function get_last_updated(){
     $last_updated = DB::table('information_schema.tables')->where('table_schema','ranklist')->select('update_time')->limit(1)->orderBy("update_time",'desc')->first()->update_time;

     return $last_updated;
  }
}



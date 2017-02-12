<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public function component_type()
    {
        return $this->belongsTo('App\ComponentType');
    }

    public function student()
    {
        return $this->belongsTo('App\Student');
    }
}

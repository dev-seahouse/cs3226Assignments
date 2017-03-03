@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <div class="form-group">
    <h2 align="center">EDIT COMPONENT</h2>
    <h3 align="center">{{$section}}</h3>
    {!! Form::open(['url' => 'editAllStudent/'.$section, 'method' => 'post']) !!}
    {{ csrf_field() }}
    <!-- http://stackoverflow.com/questions/28028996/laravel-passing-variable-from-forms 參考-->
    {!! Form::hidden('studentCount', count($students)) !!}
    <br>
    <?php
    $fields = array();
    for($i = 1; $i <= count($students); $i++){
      array_push($fields, $section."_".$i);
    }

    $hasRequiredError = false;
    foreach ($fields as $field) {
      if ($errors->has($field)) {
        $hasFormatError = true;
        if (strpos($errors->get($field)[0], 'required') !== false) {
          $hasRequiredError = true;
        }
      }
    }
    // this is required as TC1 and TC2 have different max points and thus validation
    if ($component == 'TC') {
      $comp = $section;
    } else {
      $comp = $component;
    }
    ?>

    <?php $i = 0; ?>
    <div class="col-xs-1"></div>
    <div class="col-xs-10">
      @include('invalidErrorGroup', array('comp' => $comp, 'fields' => $fields))
      <ul class="list-group row">
        @foreach ($students as $student)
        <?php $i++; ?>
        <li class="list-group-item col-xs-12 col-sm-6 col-md-3 col-lg-2" style="border:0px;">
          <div>{{ $i.'. '.$student['student']['name'] }}</div>
          <div class='{{ $errors->has($section."_".$student["student_id"]) ? "has-error" : "" }}'>{!! Form::hidden($i, $student['student_id']) !!}
            {!! Form::text($section.'_'.$i,
            $hasRequiredError == true ? "" : ($student['score'] == null ? ($component == 'MC' ? 'x.y' : ($component == 'TC' ? 'xy.z' : ($component == 'HW' ? 'x.y' : ($component == 'BS' ? 'x' : ($component == 'KS' ? 'x' : 'x'))))) : $student['score']),
            ['class' => 'form-control']) !!}</div>
        </li>
        @endforeach
      </ul>
    </div>

  </div><br><br>
  <div class="form-group"> {{-- Don't forget to create a submit button --}}
    {!! Form::submit('Update', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop




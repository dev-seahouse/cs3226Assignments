@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <div class="form-group">
    {!! Form::open(['url' => 'editAllStudent/'.$section, 'method' => 'post']) !!}
    <!-- http://stackoverflow.com/questions/28028996/laravel-passing-variable-from-forms 參考-->
    {!! Form::hidden('studentCount', count($students)) !!}
    {!! Form::label($section, $component.' '.$week.' scores:', ['class' => 'control-label']) !!}<br>
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
    ?>
    @include('invalidErrorGroup', array('comp' => $section, 'fields' => $fields))
    <?php $i = 0; ?>
    @foreach ($students as $student)
    <br>
    <div class="col-md-2">{{ $i += 1 }}</div>
    <div class="col-md-4">{{ $student['student']['name'] }}</div>
    <div class='col-md-3 {{ $errors->has($section."_".$student["student_id"]) ? "has-error" : "" }}'>
      {!! Form::hidden($i, $student['student_id']) !!}
      {!! Form::text($section.'_'.$i,
      $hasRequiredError == true ? "" : ($student['score'] == null ? ($component == 'MC' ? 'x.y' : ($component == 'TC' ? 'xy.z' : ($component == 'HW' ? 'x.y' : ($component == 'BS' ? 'x' : ($component == 'KS' ? 'x' : 'x'))))) : $student['score']),
      ['class' => 'form-control']) !!}</div><br><br>
    @endforeach
  </div><br><br>
  <div class="form-group"> {{-- Don't forget to create a submit button --}}
    {!! Form::submit('Update', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop




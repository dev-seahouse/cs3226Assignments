@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2>EDIT STUDENT</h2>
  {!! Form::open(['url' => 'editStudent', 'method' => 'post']) !!}
  <div class="form-group"> {{-- Group related form components together --}}
    {!! Form::label('idlabel', 'ID:', ['class' => 'control-label']) !!}
    {!! Form::text('id', $student['id'], ['readonly', 'class' => 'form-control']) !!}
  </div>
  <div class="form-group"> {{-- Group related form components together --}}
    {!! Form::label('nicknamelabel', 'Nick Name:', ['class' => 'control-label']) !!}
    {!! Form::text('nickname', $student['nick'], ['class' => 'form-control']) !!}
  </div>
  <div class="form-group"> {{-- Group related form components together --}}
    {!! Form::label('fullnamelabel', 'Full Name:', ['class' => 'control-label']) !!}
    {!! Form::text('fullname', $student['name'], ['class' => 'form-control']) !!}
  </div>
  <div class="form-group"> {{-- Group related form components together --}}
    {!! Form::label('kattislabel', 'Kattis account:', ['class' => 'control-label']) !!}
    {!! Form::text('kattis', $student['kattis'], ['class' => 'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::label('MC', 'Mini contest scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('MC1', $scores_arr['MC'][0], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC2', $scores_arr['MC'][1], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC2"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC3', $scores_arr['MC'][2], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC3"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC4', $scores_arr['MC'][3], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC4"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC5', $scores_arr['MC'][4], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC5"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC6', $scores_arr['MC'][5], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC6"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC7', $scores_arr['MC'][6], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC7"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC8', $scores_arr['MC'][7], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC8"]) !!}</div>
    <div class="col-md-1">{!! Form::text('MC9', $scores_arr['MC'][8], ['step' => '0.5', 'min' => '0', 'max' => '4', 'class' => 'form-control','id'=> "MC9"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('TC', 'Team contest scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('TC1', $scores_arr['TC'][0], ['step' => '0.5', 'min' => '0', 'max' => '10.5', 'class' => 'form-control','id'=> "TC1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('TC2', $scores_arr['TC'][1], ['step' => '0.5', 'min' => '0', 'max' => '13.5', 'class' => 'form-control','id'=> "TC2"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('HW', 'Homework scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('HW1', $scores_arr['HW'][0], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW2', $scores_arr['HW'][1], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW2"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW3', $scores_arr['HW'][2], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW3"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW4', $scores_arr['HW'][3], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW4"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW5', $scores_arr['HW'][4], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW5"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW6', $scores_arr['HW'][5], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW6"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW7', $scores_arr['HW'][6], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW7"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW8', $scores_arr['HW'][7], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW8"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW9', $scores_arr['HW'][8], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW9"]) !!}</div>
    <div class="col-md-1">{!! Form::text('HW10', $scores_arr['HW'][9], ['step' => '0.5', 'min' => '0', 'max' => '1.5', 'class' => 'form-control','id'=> "HW10"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('Bs', 'Problem Bs scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('Bs1', $scores_arr['BS'][0], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs2', $scores_arr['BS'][1], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs2"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs3', $scores_arr['BS'][2], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs3"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs4', $scores_arr['BS'][3], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs4"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs5', $scores_arr['BS'][4], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs5"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs6', $scores_arr['BS'][5], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs6"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs7', $scores_arr['BS'][6], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs7"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs8', $scores_arr['BS'][7], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs8"]) !!}</div>
    <div class="col-md-1">{!! Form::text('Bs9', $scores_arr['BS'][8], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "Bs9"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('KS', 'Kattis set scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('KS1', $scores_arr['KS'][0], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS2', $scores_arr['KS'][1], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS2"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS3', $scores_arr['KS'][2], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS3"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS4', $scores_arr['KS'][3], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS4"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS5', $scores_arr['KS'][4], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS5"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS6', $scores_arr['KS'][5], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS6"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS7', $scores_arr['KS'][6], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS7"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS8', $scores_arr['KS'][7], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS8"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS9', $scores_arr['KS'][8], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS9"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS10', $scores_arr['KS'][9], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS10"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS11', $scores_arr['KS'][10], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS11"]) !!}</div>
    <div class="col-md-1">{!! Form::text('KS12', $scores_arr['KS'][11], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "KS12"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('AC', 'Achievement scores:', ['class' => 'control-label']) !!}<br>
    <div class="col-md-1">{!! Form::text('AC1', $scores_arr['AC'][0], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "AC1"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC2', $scores_arr['AC'][1], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "AC2"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC3', $scores_arr['AC'][2], ['step' => '0.5', 'min' => '0', 'max' => '3', 'class' => 'form-control','id'=> "AC3"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC4', $scores_arr['AC'][3], ['step' => '0.5', 'min' => '0', 'max' => '3', 'class' => 'form-control','id'=> "AC4"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC5', $scores_arr['AC'][4], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "AC5"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC6', $scores_arr['AC'][5], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "AC6"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC7', $scores_arr['AC'][6], ['step' => '0.5', 'min' => '0', 'max' => '6', 'class' => 'form-control','id'=> "AC7"]) !!}</div>
    <div class="col-md-1">{!! Form::text('AC8', $scores_arr['AC'][7], ['step' => '0.5', 'min' => '0', 'max' => '1', 'class' => 'form-control','id'=> "AC8"]) !!}</div>
  </div><br>
  <div class="form-group">
    {!! Form::label('sum', 'Sum of scores (automatically computed):', ['class' => 'control-label']) !!}
    {!! Form::number('sum', 0, ['readonly', 'class' => 'form-control',]) !!}
  </div>
  <div class="form-group">
    {!! Form::label('comments', 'Specific comments:', ['class' => 'control-label']) !!}
    {!! Form::text('comments', null, ['class' => 'form-control','id'=>'sum']) !!}
  </div>
  <div class="form-group"> {{-- Don't forget to create a submit button --}}
    {!! Form::submit('Update', ['class' => 'form-control btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop
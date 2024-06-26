@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2 align="center">EDIT STUDENT</h2>
  {!! Form::open(['url' => 'editStudent', 'method' => 'post']) !!}
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="container-fluid">
        <div class="form-group"> {{-- Group related form components together --}}
          {!! Form::hidden('id', $student['id']) !!}
          {!! Form::label('nicknamelabel', 'Nick Name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'nick'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('nick', $student['nick'], ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group"> {{-- Group related form components together --}}
          {!! Form::label('fullnamelabel', 'Full Name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'name'))
          <div class="{{ $errors->has('name') ? 'has-error' : '' }}">{!! Form::text('name', $student['name'], ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group"> {{-- Group related form components together --}}
          {!! Form::label('kattislabel', 'Kattis account:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'kattis'))
          <div class="{{ $errors->has('kattis') ? 'has-error' : '' }}">{!! Form::text('kattis', $student['kattis'], ['class' => 'form-control']) !!}</div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('MC', 'Mini contest scores:', ['class' => 'control-label']) !!}<br>
          @include('invalidErrorGroup', array('comp'=>'MC', 'fields'=>['MC1','MC2','MC3','MC4','MC5','MC6','MC7','MC8','MC9']))
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC1') ? 'has-error' : '' }}">MC1 {!! Form::text('MC1', $scores_arr['MC'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC2') ? 'has-error' : '' }}">MC2 {!! Form::text('MC2', $scores_arr['MC'][1], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC3') ? 'has-error' : '' }}">MC3 {!! Form::text('MC3', $scores_arr['MC'][2], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC4') ? 'has-error' : '' }}">MC4 {!! Form::text('MC4', $scores_arr['MC'][3], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC5') ? 'has-error' : '' }}">MC5 {!! Form::text('MC5', $scores_arr['MC'][4], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC6') ? 'has-error' : '' }}">MC6 {!! Form::text('MC6', $scores_arr['MC'][5], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC7') ? 'has-error' : '' }}">MC7 {!! Form::text('MC7', $scores_arr['MC'][6], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC8') ? 'has-error' : '' }}">MC8 {!! Form::text('MC8', $scores_arr['MC'][7], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('MC9') ? 'has-error' : '' }}">MC9 {!! Form::text('MC9', $scores_arr['MC'][8], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('TC', 'Team contest scores:', ['class' => 'control-label']) !!}<br>
          @if ($errors->has('TC1') || $errors->has('TC2'))
          <div class="alert alert-danger">
            <ul>
              @if ($errors->has('TC1'))
              <li>{{ $errors->get('TC1')[0] }}</li>
              @endif
              @if ($errors->has('TC2'))
              <li>{{ $errors->get('TC2')[0] }}</li>
              @endif  
            </ul>
          </div>
          @endif
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('TC1') ? 'has-error' : '' }}">TC1 {!! Form::text('TC1', $scores_arr['TC'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('TC2') ? 'has-error' : '' }}">TC2 {!! Form::text('TC2', $scores_arr['TC'][1], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('HW', 'Homework scores:', ['class' => 'control-label']) !!}<br>
          @include('invalidErrorGroup', array('comp'=>'HW', 'fields'=>['HW1','HW2','HW3','HW4','HW5','HW6','HW7','HW8','HW9','HW10']))
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW1') ? 'has-error' : '' }}">HW1 {!! Form::text('HW1', $scores_arr['HW'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW2') ? 'has-error' : '' }}">HW2 {!! Form::text('HW2', $scores_arr['HW'][1], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW3') ? 'has-error' : '' }}">HW3 {!! Form::text('HW3', $scores_arr['HW'][2], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW4') ? 'has-error' : '' }}">HW4 {!! Form::text('HW4', $scores_arr['HW'][3], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW5') ? 'has-error' : '' }}">HW5 {!! Form::text('HW5', $scores_arr['HW'][4], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW6') ? 'has-error' : '' }}">HW6 {!! Form::text('HW6', $scores_arr['HW'][5], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW7') ? 'has-error' : '' }}">HW7 {!! Form::text('HW7', $scores_arr['HW'][6], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW8') ? 'has-error' : '' }}">HW8 {!! Form::text('HW8', $scores_arr['HW'][7], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW9') ? 'has-error' : '' }}">HW9 {!! Form::text('HW9', $scores_arr['HW'][8], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('HW10') ? 'has-error' : '' }}">HW10 {!! Form::text('HW10', $scores_arr['HW'][9], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('BS', 'Problem Bs scores:', ['class' => 'control-label']) !!}<br>
          @include('invalidErrorGroup', array('comp'=>'BS', 'fields'=>['BS1','BS2','BS3','BS4','BS5','BS6','BS7','BS8','BS9']))
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS1') ? 'has-error' : '' }}">BS1 {!! Form::text('BS1', $scores_arr['BS'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS2') ? 'has-error' : '' }}">BS2 {!! Form::text('BS2', $scores_arr['BS'][1], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS3') ? 'has-error' : '' }}">BS3 {!! Form::text('BS3', $scores_arr['BS'][2], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS4') ? 'has-error' : '' }}">BS4 {!! Form::text('BS4', $scores_arr['BS'][3], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS5') ? 'has-error' : '' }}">BS5 {!! Form::text('BS5', $scores_arr['BS'][4], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS6') ? 'has-error' : '' }}">BS6 {!! Form::text('BS6', $scores_arr['BS'][5], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS7') ? 'has-error' : '' }}">BS7 {!! Form::text('BS7', $scores_arr['BS'][6], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS8') ? 'has-error' : '' }}">BS8 {!! Form::text('BS8', $scores_arr['BS'][7], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('BS9') ? 'has-error' : '' }}">BS9 {!! Form::text('BS9', $scores_arr['BS'][8], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('KS', 'Kattis set scores:', ['class' => 'control-label']) !!}<br>
          @include('invalidErrorGroup', array('comp'=>'KS', 'fields'=>['KS1','KS2','KS3','KS4','KS5','KS6','KS7','KS8','KS9','KS10','KS11','KS12']))
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS1') ? 'has-error' : '' }}">KS1 {!! Form::text('KS1', $scores_arr['KS'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS2') ? 'has-error' : '' }}">KS2 {!! Form::text('KS2', $scores_arr['KS'][1], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS3') ? 'has-error' : '' }}">KS3 {!! Form::text('KS3', $scores_arr['KS'][2], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS4') ? 'has-error' : '' }}">KS4 {!! Form::text('KS4', $scores_arr['KS'][3], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS5') ? 'has-error' : '' }}">KS5 {!! Form::text('KS5', $scores_arr['KS'][4], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS6') ? 'has-error' : '' }}">KS6 {!! Form::text('KS6', $scores_arr['KS'][5], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS7') ? 'has-error' : '' }}">KS7 {!! Form::text('KS7', $scores_arr['KS'][6], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS8') ? 'has-error' : '' }}">KS8 {!! Form::text('KS8', $scores_arr['KS'][7], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS9') ? 'has-error' : '' }}">KS9 {!! Form::text('KS9', $scores_arr['KS'][8], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS10') ? 'has-error' : '' }}">KS10 {!! Form::text('KS10', $scores_arr['KS'][9], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS11') ? 'has-error' : '' }}">KS11 {!! Form::text('KS11', $scores_arr['KS'][10], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('KS12') ? 'has-error' : '' }}">KS12 {!! Form::text('KS12', $scores_arr['KS'][11], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('AC', 'Achievement scores:', ['class' => 'control-label']) !!}<br>
          @include('invalidErrorGroup', array('comp'=>'AC', 'fields'=>['AC1','AC2','AC3','AC4','AC5','AC6','AC7','AC8']))
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC1') ? 'has-error' : '' }}">AC1 {!! Form::text('AC1', $scores_arr['AC'][0], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC2') ? 'has-error' : '' }}">AC2 {!! Form::text('AC2', $scores_arr['AC'][1], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC3') ? 'has-error' : '' }}">AC3 {!! Form::text('AC3', $scores_arr['AC'][2], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC4') ? 'has-error' : '' }}">AC4 {!! Form::text('AC4', $scores_arr['AC'][3], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC5') ? 'has-error' : '' }}">AC5 {!! Form::text('AC5', $scores_arr['AC'][4], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC6') ? 'has-error' : '' }}">AC6 {!! Form::text('AC6', $scores_arr['AC'][5], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC7') ? 'has-error' : '' }}">AC7 {!! Form::text('AC7', $scores_arr['AC'][6], ['class' => 'form-control autosum']) !!}</div>
          <div class="col-lg-1 col-md-2 col-sm-3 col-xs-12 {{ $errors->has('AC8') ? 'has-error' : '' }}">AC8 {!! Form::text('AC8', $scores_arr['AC'][7], ['class' => 'form-control autosum']) !!}</div>
        </div><br>
      </div>
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('sum', 'Sum of scores (automatically computed):', ['class' => 'control-label']) !!}
          {!! Form::number('sum', $sum, ['readonly', 'class' => 'form-control', 'id' => 'sum']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('comments', 'Specific comments:', ['class' => 'control-label']) !!}
          {!! Form::textarea('comments', $comment, ['class' => 'form-control', 'rows' => 4]) !!}
        </div><br>
        <div class="form-group">
          {!! Form::submit('Update', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
        </div>
      </div>

    </div>
    <div class="col-sm-1"></div>
  </div>
  {!! Form::close() !!}
</div><br>
@stop
@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2 align="center">CREATE STUDENT</h2>
  {!! Form::open(['url' => 'createStudent', 'method' => 'put', 'files' => true]) !!}
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'nick'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('nick', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'name'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('name', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'kattis'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('kattis', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('nationality', 'Nationality:', ['class' => 'control-label']) !!}
          {!! Form::select('nationality', array('SGP' => 'SGP - Singaporean', 'CHN' => 'CHN - Chinese', 'VNM' => 'VNM - Vietnamese', 'IDN' => 'IDN - Indonesian', 'JPN' => 'JPN - Japanese', 'AUS' => 'AUS - Australian', 'GER' => 'GER - German', 'OTH' => 'Other Nationality')) !!}
        </div>
        <div class="form-group">
          {!! Form::label('profile_pic', 'Profile picture:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'profile_pic'))
          {!! Form::file('profile_pic', null, ['class' => 'form-control']) !!}
        </div><br>
        <div class="form-group">
          <div class="col-xs-3"></div>
          <div class="col-xs-6">
            {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary']) !!}
          </div>
          <div class="col-xs-3"></div>
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>
  {!! Form::close() !!}
</div>
@stop

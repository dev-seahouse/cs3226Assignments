@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2>CREATE STUDENT</h2>

  {!! Form::open(['url' => 'createStudent', 'method' => 'put', 'files' => true]) !!}
  <!-- It is more user friendly to highlight fields with error(s) and display 
an error message near its relevant field and you are encouraged to do so. -->
  <div class="form-group">
    {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'nick'))
    {!! Form::text('nick', null, ['class' => 'form-control']) !!}

    {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'name'))
    {!! Form::text('name', null, ['class' => 'form-control']) !!}

    {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'kattis'))
    {!! Form::text('kattis', null, ['class' => 'form-control']) !!}

    {!! Form::label('nationality', 'Nationality:', ['class' => 'control-label']) !!}
    {!! Form::select('nationality', array('SGP' => 'SGP - Singaporean', 'CHN' => 'CHN - Chinese', 'VNM' => 'VNM - Vietnamese', 'IDN' => 'IDN - Indonesian', 'OTH' => 'Other Nationality')) !!}
    <br>
    {!! Form::label('propic', 'Profile picture:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'propic'))
    {!! Form::file('propic', null, ['class' => 'form-control']) !!}
  </div>
  <div class="form-group">
    {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop

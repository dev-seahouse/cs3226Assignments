@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <div class="container-fluid">
    <h2>CREATE STUDENT</h2>
    
    {!! Form::open(['url' => 'createStudent', 'method' => 'put', 'files' => true]) !!}
    <!-- It is more user friendly to highlight fields with error(s) and display 
         an error message near its relevant field and you are encouraged to do so. -->
    @if (count($errors) > 0) 
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="form-group">
      {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
      {!! Form::text('nick', null, ['class' => 'form-control']) !!}
      {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
      {!! Form::text('name', null, ['class' => 'form-control']) !!}
      {!! Form::label('gender', 'Gender:', ['class' => 'control-label']) !!}
      {!! Form::select('gender', array('M' => 'Male', 'F' => 'Female')) !!}
      <br>
      {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
      {!! Form::text('kattis', null, ['class' => 'form-control']) !!}
      {!! Form::label('nationality', 'Nationality:', ['class' => 'control-label']) !!}
      {!! Form::select('nationality', array('SGP' => 'SGP - Singaporean', 'CHN' => 'CHN - Chinese', 'VNM' => 'VNM - Vietnamese', 'IDN' => 'IDN - Indonesian', 'OTH' => 'Other Nationality')) !!}
    </div>
    <div class="form-group">
      {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
  </div>
@stop

@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2>EDIT STUDENT</h2>

  {!! Form::open(['url' => 'editStudent', 'method' => 'post']) !!}
  <!-- It is more user friendly to highlight fields with error(s) and display 
an error message near its relevant field and you are encouraged to do so. -->
  <div class="form-group">
    {!! Form::hidden('id', json_decode($student)->ID) !!}
    {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'nick'))
    {!! Form::text('nick', json_decode($student)->NICK, ['class' => 'form-control']) !!}

    {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'name'))
    {!! Form::text('name', json_decode($student)->NAME, ['class' => 'form-control']) !!}

    {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'kattis'))
    {!! Form::text('kattis', json_decode($student)->KATTIS, ['class' => 'form-control']) !!}

    {!! Form::label('mc_components', 'Mini contest scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'mc_components'))
    {!! Form::text('mc_components', implode(',', json_decode($student)->MC_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('tc_components', 'Team contest scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'tc_components'))
    {!! Form::text('tc_components', implode(',', json_decode($student)->TC_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('hw_components', 'Homework scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'hw_components'))
    {!! Form::text('hw_components', implode(',', json_decode($student)->HW_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('bs_components', 'Problem B scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'ba_components'))
    {!! Form::text('bs_components', implode(',', json_decode($student)->BS_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('ks_components', 'Kattis set scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'ks_components'))
    {!! Form::text('ks_components', implode(',', json_decode($student)->KS_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('ac_components', 'Achievement scores:', ['class' => 'control-label']) !!}
    @include('invalidError', array('field'=>'ac_components'))
    {!! Form::text('ac_components', implode(',', json_decode($student)->AC_COMPONENTS), ['class' => 'form-control autosum']) !!}

    {!! Form::label('sum', 'Sum of scores:', ['class' => 'control-label']) !!}
    {!! Form::text('sum', json_decode($student)->SUM, ['id' => 'sum', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
  </div>
  <div class="form-group">
    {!! Form::submit('Update', ['class' => 'form-control btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop

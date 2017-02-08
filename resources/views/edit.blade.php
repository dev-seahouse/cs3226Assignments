@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <div class="container-fluid">
    <h2>EDIT STUDENT</h2>
    
    {!! Form::open(['url' => 'editStudent', 'method' => 'post']) !!}
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
      {!! Form::hidden('id', json_decode($student)->ID) !!}
      {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
      {!! Form::text('nick', json_decode($student)->NICK, ['class' => 'form-control']) !!}
      {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
      {!! Form::text('name', json_decode($student)->NAME, ['class' => 'form-control']) !!}
      {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
      {!! Form::text('kattis', json_decode($student)->KATTIS, ['class' => 'form-control']) !!}
      {!! Form::label('mc_components', 'Mini contest scores:', ['class' => 'control-label']) !!}
      {!! Form::text('mc_components', implode(',', json_decode($student)->MC_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('tc_components', 'Team contest scores:', ['class' => 'control-label']) !!}
      {!! Form::text('tc_components', implode(',', json_decode($student)->TC_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('hw_components', 'Homework scores:', ['class' => 'control-label']) !!}
      {!! Form::text('hw_components', implode(',', json_decode($student)->HW_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('bs_components', 'Problem B scores:', ['class' => 'control-label']) !!}
      {!! Form::text('bs_components', implode(',', json_decode($student)->BS_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('ks_components', 'Kattis set scores:', ['class' => 'control-label']) !!}
      {!! Form::text('ks_components', implode(',', json_decode($student)->KS_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('ac_components', 'Achievement scores:', ['class' => 'control-label']) !!}
      {!! Form::text('ac_components', implode(',', json_decode($student)->AC_COMPONENTS), ['class' => 'form-control']) !!}
      {!! Form::label('sum', 'Sum of scores:', ['class' => 'control-label']) !!}
      {!! Form::text('sum', json_decode($student)->SUM, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::submit('Update', ['class' => 'form-control btn btn-primary']) !!}
    </div>
    {!! Form::close() !!}
    
    {!! Form::open(['route' => ['delete', json_decode($student)->ID], 'method' => 'delete']) !!}
    <div class="form-group">
      {!! Form::submit('Delete', ['class' => 'form-control btn btn-danger']) !!}
    </div>
    {!! Form::close() !!}
  </div>
@stop

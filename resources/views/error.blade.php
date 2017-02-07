@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <div class="container-fluid">
    <h2 class="text-center no-margin">{{ $message }}</h2>
    <div class="help-block"></div>
  </div>
@stop

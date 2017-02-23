@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Progress Chart</h1>

  <div class="row">
    <div>
      <canvas id="progressChart"></canvas>
    </div>
  </div>
@stop

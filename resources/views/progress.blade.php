@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Progress Chart</h1>
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10 text-center">
      <div>
        <button id="progressChartHideButton" class="btn btn-primary btn-fixed-width" style="margin: 1em 0em 1em 0em;">Toggle all students</button>
        <canvas id="progressChart"></canvas>
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
@stop

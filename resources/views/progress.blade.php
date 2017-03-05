@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">{{__('messages.progressChart')}}</h1>
  <div class="row hidden-sm">
    <div class="col-sm-1"></div>
    <div class="col-sm-10 text-center">
      <div>
        <button id="progressChartHideButton" class="btn btn-primary btn-fixed-width" style="margin: 1em 0em 1em 0em;">{{__('messages.ToggleAllStudent')}}</button>
        <canvas id="progressChart"></canvas>
      </div>
    </div>
    
    <div class="col-sm-1"></div>
  </div>
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10 text-center" style="margin-top: 20px;">
      <span style="font-size: 20px;">The progress chart is best viewed on a larger screen!</span>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>
@stop

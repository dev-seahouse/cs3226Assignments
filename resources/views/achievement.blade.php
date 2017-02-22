@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Achievement Board</h1>

  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <?php 
      $subRecords = $records->where('aId', 1);
      $title = $achievements->where('id', 1)->first()->title;
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      
      <?php 
      $subRecords = $records->where('aId', 2);
      $title = $achievements->where('id', 2)->first()->title;
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      
      
      @for ($i = 1; $i <= 3; $i++)
      <?php 
      $subRecords = $records->where('aId', 3)->where('points', $i);
      $title = $achievements->where('id', 3)->first()->title.' '.$i.'/3';
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      @endfor
      
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>




@stop
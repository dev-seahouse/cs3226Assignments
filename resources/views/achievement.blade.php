@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Achievement Board</h1>

  <div class="row">
    <div class="col-xs-1"></div>
    <div class="col-xs-10">
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
      
      @for ($i = 1; $i <= 3; $i++)
      <?php 
      $subRecords = $records->where('aId', 4)->where('points', $i);
      $title = $achievements->where('id', 4)->first()->title.' '.$i.'/3';
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      @endfor
      
      <?php 
      $subRecords = $records->where('aId', 5);
      $title = $achievements->where('id', 5)->first()->title;
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      
      <?php 
      $subRecords = $records->where('aId', 6);
      $title = $achievements->where('id', 6)->first()->title;
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      
      @for ($i = 1; $i <= 6; $i++)
      <?php 
      $subRecords = $records->where('aId', 7)->where('points', $i);
      $title = $achievements->where('id', 7)->first()->title.' '.$i.'/6';
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      @endfor
      
      <?php 
      $subRecords = $records->where('aId', 8);
      $title = $achievements->where('id', 8)->first()->title;
      ?>
      @include('acBoard', array('title' => $title, 'subRecords' => $subRecords))
      
      </div>
    </div>
    <div class="col-xs-1"></div>
  </div>
</div>




@stop
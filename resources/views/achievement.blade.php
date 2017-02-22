@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Achievements</h1>
  <br>

  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-xs-12 col-sm-6">
      <table id="actable" class="table table-hover">
        <thead>
          <tr>
            <th class="col-xs-1">R</th>
            <th class="col-xs-3">Achievement</th>
            <th class="col-xs-3">Student</th>
          </tr>
        <tbody>
          <?php $i = 1; ?>
          @foreach($records as $record)
          <?php
          if ($record->max_points != 1) {
            $acTitle = $record->title.' '.$record->points.'/'.$record->max_points;
          } else {
            $acTitle = $record->title;
          }
          ?>
          <tr>
            <td class="col-xs-1">{{ $i }}</td>
            <td class="col-xs-3">{{ $acTitle }}</td>
            <td class="col-xs-3"><a href="{{ route('student', ['id' => $record->sId]) }}">{{ $record->name }}</a></td>
          </tr>
          <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="col-sm-3"></div>
  </div>
</div>
@stop
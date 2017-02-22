<?php 
$subRecords = $records->where('aId', $id)->where('points', $point);
$ac = $achievements->where('id', $id)->first();
if ($ac->max_points != 1) {
  $title = $ac->title.' '.$point.'/'.$ac->max_points;
}
else {
  $title = $ac->title;
}
?>
@if (count($subRecords) > 0)
<br>
<section class="{{ $sectionClass }}">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="{{ $headingId }}">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}">
          <h4><b>{{ $title }}</b></h4>
        </a>
      </h4>
    </div>
    <div id="{{ $collapseId }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $headingId }}">
      <div class="panel-body">
        <ul class="list-group row">
          @foreach ($subRecords as $record)
          <li class="list-group-item board-item col-xs-12 col-sm-6 col-md-3">
            <a href="{{ route('student', ['id' => $record->sId]) }}">{{ $record->name }}</a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>
@endif
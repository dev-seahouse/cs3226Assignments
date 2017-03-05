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
          <h4><b><?php 
            if($title=="Let it begins")echo __('messages.let-it-begin');
            else if($title=="Quick starter")echo __('messages.Quick-starter');
            else if($title=="Active in class 1/3")echo __('messages.Active-in-class-1/3');
            else if($title=="Active in class 2/3")echo __('messages.Active-in-class-2/3');
            else if($title=="Active in class 3/3")echo __('messages.Active-in-class-3/3');
            else if($title=="Surprise us 1/3")echo __('messages.Surprise-us-1/3');
            else if($title=="Surprise us 2/3")echo __('messages.Surprise-us-2/3');
            else if($title=="Surprise us 3/3")echo __('messages.Surprise-us-3/3');
            else if($title=="High determination")echo __('messages.High-determination');
            else if($title=="Bookworm")echo __('messages.Bookworm');
            else if($title=="Kattis apprentice 1/6")echo __('messages.Kattis-apprentice-1/6');
            else if($title=="Kattis apprentice 2/6")echo __('messages.Kattis-apprentice-2/6');
            else if($title=="Kattis apprentice 3/6")echo __('messages.Kattis-apprentice-3/6');
            else if($title=="Kattis apprentice 4/6")echo __('messages.Kattis-apprentice-4/6');
            else if($title=="Kattis apprentice 5/6")echo __('messages.Kattis-apprentice-5/6');
            else if($title=="Kattis apprentice 6/6")echo __('messages.Kattis-apprentice-6/6');
            else if($title=="CodeForces Specialist")echo __('messages.CodeForces-Specialist');
          ?></b></h4>
        </a>
      </h4>
    </div>
    <div id="{{ $collapseId }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="{{ $headingId }}">
      <div class="panel-body">
        <ul class="list-group row">
          @foreach ($subRecords as $record)
          <li class="list-group-item col-xs-6 col col-sm-4 col-md-3" style="border:0px;">
            <a href="{{ route('student', ['id' => $record->sId]) }}" style="text-align: center; display: block;"><img class="detailsImage" src="{{ URL::asset('img/student/'.$record->profile_pic) }}" style="max-width: 100px; height: 100px; min-width: 80px;">{{ $record->name }}</a>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>
@endif
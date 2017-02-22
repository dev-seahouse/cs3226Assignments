@if (count($subRecords) > 0)
<br>
<h3>{{ $title }}</h3>
<div class="container-fluid board">
  <ul class="list-group row">
    @foreach ($subRecords as $record)
    <li class="list-group-item board-item col-xs-6 col-sm-4 col-md-3 col-lg-2">
      <a href="{{ route('student', ['id' => $record->sId]) }}">{{ $record->name }}</a>
    </li>
    @endforeach
  </ul>
</div>
@endif
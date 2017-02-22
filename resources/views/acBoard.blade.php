@if (count($subRecords) > 0)
<h3>{{ $title }}</h3>
<ul class="list-group row">
  @foreach ($subRecords as $record)
  <li class="list-group-item col-xs-6 col-sm-4 col-md-3 col-lg-2">
    <a href="{{ route('student', ['id' => $record->sId]) }}">{{ $record->name }}</a>
  </li>
  @endforeach
</ul>
@endif
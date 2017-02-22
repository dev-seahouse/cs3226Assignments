<h3>{{ $title }}</h3>
@if (count($subRecords) > 0)
<ul class="list-group row">
  @foreach ($subRecords as $record)
  <li class="list-group-item col-xs-6 col-sm-4 col-md-3">
    <a href="{{ route('student', ['id' => $record->sId]) }}">{{ $record->name }}</a>
  </li>
  @endforeach
</ul>
@else
<p>There are no students with this achievement.</p>
@endif
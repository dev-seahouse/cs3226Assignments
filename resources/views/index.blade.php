@extends('template') <!-- use template from previous slide -->
@section('main') <!-- define a section called main -->
<div class="container-fluid">

  <h1 class="text-center no-margin">Rankings</h1>

  <div class="row">
    <div class="col-xs-12">
      <table id="ranktable" class="table table-hover">
        <thead>
          <tr>
            <th>R</th>
            <th class="hidden-xs">Flag</th>
            <th class="hidden-xs">Name</th>
            <th class="visible-xs">Nick</th>
            <th class="hidden-xs hidden-sm">MC</th>
            <th class="hidden-xs hidden-sm">TC</th>
            <th>SPE</th>
            <th class="hidden-xs hidden-sm">HW</th>
            <th class="hidden-xs hidden-sm">Bs</th>
            <th class="hidden-xs hidden-sm">KS</th>
            <th class="hidden-xs hidden-sm">Ac</th>
            <th>DIL</th>
            <th>Sum</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; ?>
          @foreach(json_decode($students, true) as $student)
            <tr>
              <td><?php echo $i;?></td>
              <td class="hidden-xs"><img src="{{ URL::asset('img/'.$student['FLAG'].'.png') }}" class="rank-flag-img"> {{ $student['FLAG'] }}</td>
              <td class="hidden-xs">
                <img src=
                @if ($student['GENDER'] == "M")
                  "{{ URL::asset('img/student/male-icon.png') }}"
                @else
                  "{{ URL::asset('img/student/female-icon.png') }}"
                @endif
                class="rank-person-img">
                <img src="img/kattis.png" class="rank-kattis-img">
                <a href="{{ route('student', ['id' => $student['ID']]) }}">{{ $student['NAME'] }}</a></td>
              <td class="visible-xs"><a href="{{ route('student', ['id' => $student['ID']]) }}">{{ $student['NICK'] }}</a></td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[0] === $student['MC']) { echo ' highlighted'; }?>">{{ $student['MC'] }}</td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[1] === $student['TC']) { echo ' highlighted'; }?>">{{ $student['TC'] }}</td>
              <td<?php if ($maxArray[2] === $student['SPE']) { echo ' class="highlighted"'; }?>>{{ $student['SPE'] }}</td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[3] == $student['HW']) { echo ' highlighted'; }?>">{{ $student['HW'] }}</td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[4] == $student['BS']) { echo ' highlighted'; }?>">{{ $student['BS'] }}</td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[5] == $student['KS']) { echo ' highlighted'; }?>">{{ $student['KS'] }}</td>
              <td class="hidden-xs hidden-sm<?php if ($maxArray[6] == $student['AC']) { echo ' highlighted'; }?>">{{ $student['AC'] }}</td>
              <td<?php if ($maxArray[7] === $student['DIL']) { echo ' class="highlighted"'; }?>>{{ $student['DIL'] }}</td>
              <td class="js-rankTotl<?php if ($maxArray[8] == $student['SUM']) { echo ' highlighted'; }?>">{{ $student['SUM'] }}</td>
            </tr>
            <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@stop
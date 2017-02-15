@extends('template') <!-- use template from previous slide -->
@section('main') <!-- define a section called main -->
<div class="container-fluid">
  <?php 
    //$data = json_decode($students);
    //echo var_dump($data[0]);
    //echo '<br>';
    //echo var_dump($data[0]->comment->comment);
  ?>
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
          @foreach(json_decode($studentsOld, true) as $student)
            <tr>
              <td class="<?php echo printPosClass($student['SUM'], $first, $second, $third, $last);?>"><?php echo $i;?></td>
              <td class="hidden-xs <?php echo printPosClass($student['SUM'], $first, $second, $third, $last);?>"><img src="{{ URL::asset('img/'.$student['FLAG'].'.png') }}" class="rank-flag-img"> {{ $student['FLAG'] }}</td>
              <td class="hidden-xs <?php echo printPosClass($student['SUM'], $first, $second, $third, $last);?>">
                <img src="{{ URL::asset('img/student/'.$student['PROPIC']) }}" class="rank-person-img">
                <img src="img/kattis.png" class="rank-kattis-img">
                <a href="{{ route('student', ['id' => $student['ID']]) }}">{{ $student['NAME'] }}</a></td>
              <td class="visible-xs <?php echo printPosClass($student['SUM'], $first, $second, $third, $last);?>"><a href="{{ route('student', ['id' => $student['ID']]) }}">{{ $student['NICK'] }}</a></td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[0], $student['MC']);
                         ?>">{{ $student['MC'] }}</td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[1], $student['TC']);
                         ?>">{{ $student['TC'] }}</td>
              <td class="<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[2], $student['SPE']);
                         ?>">{{ $student['SPE'] }}</td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[3], $student['HW']);
                         ?>">{{ $student['HW'] }}</td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[4], $student['BS']);
                         ?>">{{ $student['BS'] }}</td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[5], $student['KS']);
                         ?>">{{ $student['KS'] }}</td>
              <td class="hidden-xs hidden-sm<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[6], $student['AC']);
                         ?>">{{ $student['AC'] }}</td>
              <td class="<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[7], $student['DIL']);
                         ?>">{{ $student['DIL'] }}</td>
              <td class="js-rankTotl<?php 
                         echo printPosClass($student['SUM'], $first, $second, $third, $last);
                         echo printHLClass($maxArray[8], $student['SUM']);
                         ?>">{{ $student['SUM'] }}</td>
            </tr>
            <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php
  function printHLClass($max, $value) {
    if ($max == $value) {
       return ' highlighted';
    }
    return '';
  }

  function printPosClass($sum, $first, $second, $third, $last) {
    if ($sum == $first) {
      return ' gold';
    } else if ($sum == $second) {
      return ' silver';
    } else if ($sum == $third) {
      return ' bronze';
    } else if ($sum == $last) {
      return ' last';
    }
    
    return '';
  }
?>

@stop
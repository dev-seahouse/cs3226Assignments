@extends('template') <!-- use template from previous slide -->
@section('main') <!-- define a section called main -->
<div class="container-fluid">
  <?php 
    //echo var_dump($data[0]->scores);
    
    //try to retrieve summed data and display using blade format.
    //if too hard then do the sum in php and echo the result into cells.
    
    //for profile_pic use /img/student/{nick}.png
    //for flags use /img/flags/{nationality}.png
    
    //use /test route to test your query results
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
          @foreach($students as $student)
            <?php 
              /* moved calculation into student api
              $compScores = $student->getCompScores();
              $scores = array(
                  'MC' => $compScores[0]->total,
                  'TC' => $compScores[1]->total,
                  'HW' => $compScores[2]->total,
                  'BS' => $compScores[3]->total,
                  'KS' => $compScores[4]->total,
                  'AC' => $compScores[5]->total
                );
              $spe = $scores['MC'] + $scores['TC'];
              $dil = $scores['HW'] + $scores['BS'] + $scores['KS'] + $scores['AC'];
              $sum = $spe + $dil;*/
            ?>
            <tr>
              <td class=""><?php echo $i;?></td>
              <td class="hidden-xs">
                <img src="{{ URL::asset('img/flags/'.$student['nationality'].'.png') }}" class="rank-flag-img"> {{ $student['nationality'] }}
              </td>
              <td class="hidden-xs">
                <img src="{{ URL::asset('img/student/'.$student['nick'].'.png') }}" class="rank-person-img">
                <img src="img/kattis.png" class="rank-kattis-img">
                <a href="{{ route('student', ['id' => $student['id']]) }}">{{ $student['name'] }}</a>
              </td>
              <td class="visible-xs">
                <a href="{{ route('student', ['id' => $student['id']]) }}">{{ $student['nick'] }}</a>
              </td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->mc }}</td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->tc }}</td>
              <td class="">{{ $student['components'][0]->mc + $student['components'][0]->tc }}</td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->hw }}</td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->bs }}</td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->ks }}</td>
              <td class="hidden-xs hidden-sm">{{ $student['components'][0]->ac }}</td>
              <td class="">{{ $student['components'][0]->hw + $student['components'][0]->bs + $student['components'][0]->ks + $student['components'][0]->ac }}</td>
              <td class="js-rankTotl">{{ $student['components'][0]->mc + $student['components'][0]->tc + $student['components'][0]->hw + $student['components'][0]->bs + $student['components'][0]->ks + $student['components'][0]->ac }}</td>
            </tr>
            <?php $i++; ?>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@stop
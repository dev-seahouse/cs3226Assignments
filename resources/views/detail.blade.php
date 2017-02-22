@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h2>STUDENT DETAILS</h2>

  <div class="row">
    <div class="col-xs-12 col-sm-6">
      <h4><b>{{ $student['name'] }}</b> in CS3233 S2 AY 2016/2017</h4>
      <p>Kattis account: {{ $student['kattis'] }}</p>
      <?php
      $spe = $components['mc'] + $components['tc'];
      $dil = $components['hw'] + $components['bs'] + $components['ks'] + $components['ac'];
      $sum = $spe + $dil;
      ?>
      <p>
        <b>SPE</b>(ed) component: <b>{{$components['mc'].' + '.$components['tc'].' = '.$spe}}</b><br>
        <b>DIL</b>(igence) component: <b>{{$components['hw'].' + '.$components['bs'].' + '.$components['ks'].' + '.$components['ac'].' = '.$dil}}</b><br>
        <b>SUM = {{$spe.' + '.$dil.' = '.$sum}}</b>
      </p>
    </div>
    <div class="col-sm-3 pull-right">
      <div class="col-sm-6 hidden-xs hidden-sm" >
        <img class="detailsImage" src="{{ URL::asset('img/flags/'.$student['nationality'].'.png') }}">
      </div>
      <div class="col-sm-6 hidden-xs">
        <img class="detailsImage" src="{{ URL::asset('img/student/'.$student['profile_pic']) }}">
      </div>
    </div>

    <div class="hidden-xs col-sm-3 col-md3 pull-right" style="max-width: 300px;">
      <canvas id="studentRadarChart" class='radarChart' width="150" height="150" style="display: block; height: 165px; width: 165px;"></canvas>
    </div>
  </div>

  <hr>

  <div class="row">
    <div class="col-xs-12">
      <table id="statstable" class="table table-striped">
        <caption>Detailed scores:</caption>
        <thead>
          <tr>
            <th>Component</th>
            <th>Sum</th>
            <th class="hidden-xs">01</th>
            <th class="hidden-xs">02</th>
            <th class="hidden-xs">03</th>
            <th class="hidden-xs">04</th>
            <th class="hidden-xs">05</th>
            <th class="hidden-xs">06</th>
            <th class="hidden-xs">07</th>
            <th class="hidden-xs">08</th>
            <th class="hidden-xs">09</th>
            <th class="hidden-xs">10</th>
            <th class="hidden-xs">11</th>
            <th class="hidden-xs">12</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Mini Contests</td>
            <td>{{ $components['mc'] }}</td>
            @foreach ($scores_arr['MC'] as $MC)
            <td class="hidden-xs">{{ $MC }}</td>
            @endforeach
          </tr>
          <tr>
            <td>Team Contests</td>
            <td>{{ $components['tc'] }}</td>
            @foreach ($scores_arr['TC'] as $TC)
            <td class="hidden-xs">{{ $TC }}</td>
            @endforeach
          </tr>
          <tr>
            <td>Homework</td>
            <td>{{ $components['hw'] }}</td>
            @foreach ($scores_arr['HW'] as $HW)
            <td class="hidden-xs">{{ $HW }}</td>
            @endforeach
          </tr>
          <tr>
            <td>Problem Bs</td>
            <td>{{ $components['bs'] }}</td>
            @foreach ($scores_arr['BS'] as $BS)
            <td class="hidden-xs">{{ $BS }}</td>
            @endforeach
          </tr>
          <tr>
            <td>Kattis Sets</td>
            <td>{{ $components['ks'] }}</td>
            @foreach ($scores_arr['KS'] as $KS)
            <td class="hidden-xs">{{ $KS }}</td>
            @endforeach
          </tr>
          <tr>
            <td>Achievements</td>
            <td>{{ $components['ac'] }}</td>
            @foreach ($scores_arr['AC'] as $AC)
            <td class="hidden-xs">{{ $AC }}</td>
            @endforeach
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <hr>
  <!--Achievement section -->
  <div class="row">
    <div class="col-xs-12">
      <p>Achievement details:</p>
      <ol>
        <?php
        $ac_scores = $scores_arr['AC'];
        for ($i = 0; $i < sizeof($ac_scores); $i++) {
          if ($ac_scores[$i] == 'x') continue;
          echo '<li>'.$achievements[$i]->title;
          if ($achievements[$i]->max_points != 1) {
            echo ' '.$ac_scores[$i].'/'.$achievements[$i]->max_points;
          }
          echo '</li>';
        }
        ?>
      </ol>

    </div>
  </div>
  <hr>
  <!--Comment section -->
  <div class="row">
    <div class="col-xs-12">
      <p>Specific comments about this student:</p>
      <p><b>{{$comment}}</b></p>
    </div>
  </div><br>

  @if (Auth::guest())
  @else
  <div class="row">
    <div class="col-xs-12">
      <a href="{{ route('edit', ['id' => $student['id']]) }}" class="btn btn-primary btn-fixed-width center-block">Edit</a>
      {!! Form::open(['route' => ['delete', $student['id']], 'method' => 'delete']) !!}
      <div class="form-group">
        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-fixed-width center-block delete-btn']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
  @endif
</div>
@stop

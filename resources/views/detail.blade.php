@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <div class="container-fluid">
    <h2>STUDENT DETAILS</h2>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h4><b>{{ $student['name'] }}</b> in CS3233 S2 AY 2016/2017</h4>

            <p>Kattis account: {{ $student['kattis'] }}</p>
            <?php
              $mc_sum = array_sum($scores_arr['MC']);
              $tc_sum = array_sum($scores_arr['TC']);
              $hw_sum = array_sum($scores_arr['HW']);
              $bs_sum = array_sum($scores_arr['BS']);
              $ks_sum = array_sum($scores_arr['KS']);
              $ac_sum = array_sum($scores_arr['AC']);
              
              $spe = $mc_sum + $tc_sum;
              $dil = $hw_sum + $bs_sum + $ks_sum + $ac_sum;
              $sum = $spe + $dil;
            ?>
            <p>
                <b>SPE</b>(ed) component: <b>{{$mc_sum . ' + ' . $tc_sum . ' = ' . $spe}}</b><br>
                <b>DIL</b>(igence) component: <b>{{$hw_sum . ' + ' . $bs_sum . ' + ' . $ks_sum . ' + ' . $ac_sum .' = ' . $dil}}</b><br>
                <b>SUM = {{$spe . ' + ' . $dil . ' = '. $sum}}</b>
            </p>

        </div>

        <div class="col-sm-3 pull-right">
            <div class="col-sm-6 hidden-xs hidden-sm" >
                <img class="detailsImage" src="{{ URL::asset('img/flags/'.$student['nationality'].'.png') }}">
            </div>
            <div class="col-sm-6 hidden-xs">
                <img class="detailsImage" src="{{ URL::asset('img/student/'.$student['nick'].'.png') }}">
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
                        <td>{{ $mc_sum }}</td>
                        @foreach ($scores_arr['MC'] as $MC)
                          <td class="hidden-xs">{{ $MC }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Team Contests</td>
                        <td>{{ $tc_sum }}</td>
                        @foreach ($scores_arr['TC'] as $TC)
                          <td class="hidden-xs">{{ $TC }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Homework</td>
                        <td>{{ $hw_sum }}</td>
                        @foreach ($scores_arr['HW'] as $HW)
                          <td class="hidden-xs">{{ $HW }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Problem Bs</td>
                        <td>{{ $bs_sum }}</td>
                        @foreach ($scores_arr['BS'] as $BS)
                          <td class="hidden-xs">{{ $BS }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Kattis Sets</td>
                        <td>{{ $ks_sum }}</td>
                        @foreach ($scores_arr['KS'] as $KS)
                          <td class="hidden-xs">{{ $KS }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>Achievements</td>
                        <td>{{ $ac_sum }}</td>
                        @foreach ($scores_arr['AC'] as $AC)
                          <td class="hidden-xs">{{ $AC }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
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
  </div>
@stop

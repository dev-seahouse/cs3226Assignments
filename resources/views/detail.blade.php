@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <div class="container-fluid">
    <h2>STUDENT DETAILS</h2>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h4><b>{{ $student['name'] }}</b> in CS3233 S2 AY 2016/2017</h4>

            <p>Kattis account: {{ $student['kattis'] }}</p>
            
          
            <p>
                <b>SPE</b>(ed) component: <b> MC + TC = SPE </b><br>
                <b>DIL</b>(igence) component: <b> HW + BS + KS + AC = DIL </b><br>
                <b>Sum = SPE + DIL = </b>
            </p>
          
        </div>

        <div class="col-sm-3 pull-right">
            <div class="col-sm-6 hidden-xs hidden-sm" >
                <img class="detailsImage" src="{{ URL::asset('img/'.$student['FLAG'].'.png') }}">
            </div>
            <div class="col-sm-6 hidden-xs">
                <img class="detailsImage" src="{{ URL::asset('img/student/'.$student['PROPIC']) }}">
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
                  <?php
//                    <tr>
//                        <td>Mini Contests</td>
//                        <td>{{ $student['MC }}</td>
//                        @foreach ($student['MC_COMPONENTS'] as $MC)
//                          <td class="hidden-xs">{{ $MC }}</td>
//                        @endforeach
//                    </tr>
//                    <tr>
//                        <td>Team Contests</td>
//                        <td>{{ $student['TC }}</td>
//                        @foreach ($student['TC_COMPONENTS'] as $TC)
//                          <td class="hidden-xs">{{ $TC }}</td>
//                        @endforeach
//                    </tr>
//                    <tr>
//                        <td>Homework</td>
//                        <td>{{ $student['HW }}</td>
//                        @foreach ($student['HW_COMPONENTS'] as $HW)
//                          <td class="hidden-xs">{{ $HW }}</td>
//                        @endforeach
//                    </tr>
//                    <tr>
//                        <td>Problem Bs</td>
//                        <td>{{ $student['BS }}</td>
//                        @foreach ($student['BS_COMPONENTS'] as $BS)
//                          <td class="hidden-xs">{{ $BS }}</td>
//                        @endforeach
//                    </tr>
//                    <tr>
//                        <td>Kattis Sets</td>
//                        <td>{{ $student['KS }}</td>
//                        @foreach ($student['KS_COMPONENTS'] as $KS)
//                          <td class="hidden-xs">{{ $KS }}</td>
//                        @endforeach
//                    </tr>
//                    <tr>
//                        <td>Achievements</td>
//                        <td>{{ $student['AC }}</td>
//                        @foreach ($student['AC_COMPONENTS'] as $AC)
//                          <td class="hidden-xs">{{ $AC }}</td>
//                        @endforeach
//                    </tr>
                  ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="row">
      <div class="col-xs-12">
        <a href="{{ route('edit', ['id' => $student['ID']]) }}" class="btn btn-primary btn-fixed-width center-block">Edit</a>
      
        {!! Form::open(['route' => ['delete', $student['ID']], 'method' => 'delete']) !!}
        <div class="form-group">
          {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-fixed-width center-block delete-btn']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@stop

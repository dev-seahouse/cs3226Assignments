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
  </div>
  <br>
  
  <div class="panel-group hidden-xs" id="accordion" role="tablist" aria-multiselectable="true">
    <section class="overview">
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
          <h4 class="panel-title">
            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              <h4>Progress comparison</h4>
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
          <div class="panel-body">
            <div class="col-sm-1 col-md-2"></div>
            <div class="col-sm-6 col-md-4">
              <canvas id="studentProgressChart" style="max-height: 300px;"></canvas>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2 col-md-4 hidden-sm" style="max-width: 300px;">
              <canvas id="studentRadarChart"></canvas>
            </div>
            <div class="col-sm-1 col-md-2"></div>
          </div>
        </div>
      </div>
    </section>
  </div>
  

  <div class="row">
    <div class="col-xs-12">
      <table id="statstable" class="table table-striped">
        <h4>Detailed scores:</h4>
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
        foreach ($records as $record) {
          if ($record->points != 0) {
            echo '<li>'.$record->title;
            if ($record->max_points != 1) {
              echo ' '.$record->points.'/'.$record->max_points;
            }
            echo '</li>';
          }
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

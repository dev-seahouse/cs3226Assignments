@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <?php
    $detail = json_decode($student);
  ?>
  <div class="container-fluid">
    <h2>STUDENT DETAILS</h2>

    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <h4><b><?php echo $detail->NAME; ?></b> in CS3233 S2 AY 2016/2017</h4>

            <p>Kattis account: <?php echo $detail->KATTIS; ?></p>

            <p>
                <b>SPE</b>(ed) component: <b><?php echo $detail->MC." + ".$detail->TC." = ".($detail->SPE); ?></b><br>
                <b>DIL</b>(igence) component: <b><?php echo $detail->HW." + ".$detail->BS." + ".$detail->KS." + ".$detail->AC." = ".($detail->DIL); ?></b><br>
                <b>Sum = SPE + DIL = <?php echo $detail->SPE." + ".$detail->DIL." = ".($detail->SUM); ?></b>
            </p>
        </div>

        <div class="col-sm-3 pull-right">
            <div class="col-sm-6 hidden-xs hidden-sm" >
                <img class="detailsImage" src=<?php echo '"/img/'.$detail->FLAG.'.png"'; ?>>
            </div>
            <div class="col-sm-6 hidden-xs">
                <img class="detailsImage" src=<?php $img = ($detail->GENDER == "M") ? '"/img/male-icon.png"' : '"/img/female-icon.png"'; echo $img; ?>>
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
                        <td><?php echo $detail->MC; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->MC_COMPONENTS[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Team Contests</td>
                        <td><?php echo $detail->TC; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->TC_COMPONENTS[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Homework</td>
                        <td><?php echo $detail->HW; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->HW_COMPONENTS[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Problem Bs</td>
                        <td><?php echo $detail->BS; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->BS_COMPONENTS[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Kattis Sets</td>
                        <td><?php echo $detail->KS; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->KS_COMPONENTS[11]; ?></td>
                    </tr>
                    <tr>
                        <td>Achievements</td>
                        <td><?php echo $detail->AC; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[0]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[1]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[2]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[3]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[4]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[5]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[6]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[7]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[8]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[9]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[10]; ?></td>
                        <td class="hidden-xs"><?php echo $detail->AC_COMPONENTS[11]; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
  </div>
@stop

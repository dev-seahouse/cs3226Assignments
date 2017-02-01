@extends('template') <!-- use template from previous slide -->
@section('main') <!-- define a section called main -->
<div class="container-fluid">

  <h1 class='text-center no-margin'>Rankings</h1>

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
          <tr>
            <td>1</td>
            <td class="hidden-xs"><img src="img/SGP.png" class="rank-flag-img"> SGP</td>
            <td class="hidden-xs">
              <img src="img/female-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img">
              <a href="{{route('student', ['id' => 1])}}">Alice [R]</a></td>
            <td class="visible-xs"><a href="{{route('student', ['id' => 1])}}">alice</a></td>
            <td class="hidden-xs hidden-sm">4</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>4</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">4</td>
            <td>7</td>
            <td class='js-rankTotl'>11</td>
          </tr>
          <tr>
            <td>2</td>
            <td class="hidden-xs"><img src="img/SGP.png" class="rank-flag-img"> SGP</td>
            <td class="hidden-xs">
              <img src="img/male-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img">
              <a href="{{route('student', ['id' => 2])}}">Bob [R]</a>
            </td>
            <td class="visible-xs"><a href="{{route('student', ['id' => 2])}}">bob</a></td>
            <td class="hidden-xs hidden-sm">3.5</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>3.5</td>
            <td class="hidden-xs hidden-sm">1.5</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td>6.5</td>
            <td class='js-rankTotl'>10</td>
          </tr>
          <tr>
            <td>3</td>
            <td class="hidden-xs"><img src="img/SGP.png" class="rank-flag-img"> SGP</td>
            <td class="hidden-xs">
              <img src="img/male-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img">
              <a href="{{route('student', ['id' => 3])}}">Charles [R]</a>
            </td>
            <td class="visible-xs"><a href="{{route('student', ['id' => 3])}}">charles</a></td>
            <td class="hidden-xs hidden-sm">4</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>4</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">3</td>
            <td>6</td>
            <td class='js-rankTotl'>10</td>
          </tr>
          <tr>
            <td>4</td>
            <td class="hidden-xs"><img src="img/VNM.png" class="rank-flag-img"> VNM</td>
            <td class="hidden-xs">
              <img src="img/male-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img"> David
            </td>
            <td class="visible-xs">david</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>1</td>
            <td class="hidden-xs hidden-sm">1.5</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td class="hidden-xs hidden-sm">4</td>
            <td>8.5</td>
            <td class='js-rankTotl'>9.5</td>
          </tr>
          <tr>
            <td>5</td>
            <td class="hidden-xs"><img src="img/MYS.png" class="rank-flag-img"> MYS</td>
            <td class="hidden-xs">
              <img src="img/female-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img"> Eve
            </td>
            <td class="visible-xs">eve</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>1</td>
            <td class="hidden-xs hidden-sm">1.5</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td class="hidden-xs hidden-sm">3</td>
            <td>7.5</td>
            <td class='js-rankTotl'>8.5</td>
          </tr>
          <tr>
            <td>6</td>
            <td class="hidden-xs"><img src="img/VNM.png" class="rank-flag-img"> VNM</td>
            <td class="hidden-xs">
              <img src="img/male-icon.png" class="rank-person-img" />
              <img src="img/kattis.png" class="rank-kattis-img" /> Flan
            </td>
            <td class="visible-xs">flan</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>1</td>
            <td class="hidden-xs hidden-sm">1.5</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td class="hidden-xs hidden-sm">3</td>
            <td>6.5</td>
            <td class='js-rankTotl'>7.5</td>
          </tr>
          <tr>
            <td>7</td>
            <td class="hidden-xs"><img src="img/SGP.png" class="rank-flag-img"> SGP</td>
            <td class="hidden-xs">
              <img src="img/male-icon.png" class="rank-person-img">
              <img src="img/kattis.png" class="rank-kattis-img"> George
            </td>
            <td class="visible-xs">george</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td class="hidden-xs hidden-sm">0</td>
            <td>0</td>
            <td class="hidden-xs hidden-sm">1.5</td>
            <td class="hidden-xs hidden-sm">1</td>
            <td class="hidden-xs hidden-sm">2</td>
            <td class="hidden-xs hidden-sm">3</td>
            <td>7.5</td>
            <td class='js-rankTotl'>7.5</td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</div>

@stop
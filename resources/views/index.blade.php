@extends('template') <!-- use template from previous slide -->
@section('main') <!-- define a section called main -->
<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="container-fluid">
  @if (Session::has('message'))
    <div id="success-alert" class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {!! session('message') !!}
    </div>
  @endif
  
  <h1 class="text-center no-margin">{{ __('messages.rankings') }}</h1>
  <div class="text-center no-margin sharing">
    <div class="fb-like" data-href="http://cs3226officialranklist.tk/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
  </div>
  <div class="text-center no-margin sharing">
	 <a href="https://twitter.com/intent/tweet?screen_name=CS3226_Official" class="twitter-mention-button" data-show-count="false">Tweet to @CS3226_Official</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <a href="https://twitter.com/CS3226_Official" class="twitter-follow-button" data-size="normal" style="vertical-align: text-bottom;">Follow @CS3226_Official</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
  </div>
  <h5 class="text-center">{{ __('messages.updateDesc') }} {{ $last_updated }}</h5>
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
          <?php 
          if(Auth::guest()) $role = 'guest';
          else if (Auth::user()->role == 'student') $role = 'student';
          else if (Auth::user()->role == 'admin') $role = 'admin';
          else $role = 'guest';
          ?>
          @foreach($students as $student)
          <?php if ($role == 'guest' && $i > 7) break; ?>
          <?php 
            if ($role == 'student') {
              if ($i > 7 && $i != $user_pos && $i != ($user_pos+1) && $i != ($user_pos-1)) {
                $i++;
                continue;
              }
            }
          
          ?>
            <tr>
              <td class=""><?php echo $i;?></td>
              <td class="hidden-xs">
                <img src="{{ URL::asset('img/flags/'.$student['nationality'].'.png') }}" class="rank-flag-img"> {{ $student['nationality'] }}
              </td>
              <td class="hidden-xs">
                <img src="{{ URL::asset('img/student/'.$student['profile_pic']) }}" class="rank-person-img">
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

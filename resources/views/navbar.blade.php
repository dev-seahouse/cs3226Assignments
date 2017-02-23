<?php
$uri = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand<?php 
                // make navbar-brand active if current uri is index page
                if ($uri === '/') { 
                  echo ' navbar-brand-active'; 
                } ?>" href="{{route('index')}}">
        <span><img src="{{ URL::asset('img/omega-lightblue.png') }}" id="brandImage"></span> CS3233 Ranklist 2017
      </a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse">
      <p class="navbar-text">
        <!--this is to create more space between brand and list-->
      </p>
      <ul class="nav navbar-nav">
        <?php
        // add edit mode to navbar if current uri is edit student page
        if (strpos($uri, '/student/edit/') !== false) {
          echo '<li class="active"><a>Edit Mode</a></li>';
        } 
        // add detail mode to navbar if current uri is student details page
        else if (strpos($uri, '/student/') !== false) {
          echo '<li class="active"><a>Detail Mode</a></li>';
        }
        ?>
		@if (Auth::guest())
		@else
        <li><a href="{{route('create')}}">Create New Student</a></li>
        <li class="dropdown" >
            <a href="{{route('create')}}" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" >
              Edit Students' data <span class="caret"></span>
            </a>
        

            <ul class="dropdown-menu" role="menu">
<!--          <li>
                <a href="{{ route('logout') }}">
                  Logout
                </a>
              </li> -->
              <li class="dropdown-submenu">
                <a class="test" >MC <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:0px;">
                  @for ($i = 1; $i <= 9; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "MC".$i))}}">MC{{$i}}</a></li>
                  @endfor
                </ul>
              </li>
                <li class="dropdown-submenu">
                <a class="test" >TC <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:25px;">
                  @for ($i = 1; $i <= 2; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "TC".$i))}}">TC{{$i}}</a></li>
                  @endfor
                </ul>
              </li>
              </li>
              <li class="dropdown-submenu">
                <a class="test" >HW <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:50px;">
                  @for ($i = 1; $i <= 10; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "HW".$i))}}">HW{{$i}}</a></li>
                  @endfor
                </ul>
              </li>
              <li class="dropdown-submenu">
                <a class="test" >BS <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:75px;">
                  @for ($i = 1; $i <= 9; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "BS".$i))}}">BS{{$i}}</a></li>
                  @endfor
                </ul>
              </li>            
              <li class="dropdown-submenu">
                <a class="test" >KS <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:75px;">
                  @for ($i = 1; $i <= 12; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "KS".$i))}}">KS{{$i}}</a></li>
                  @endfor
                </ul>
              </li>   
              <li class="dropdown-submenu">
                <a class="test" >AC <b class="right-caret"></b></a>
                <ul class="dropdown-menu" style="width:200px;float:left;left:160px;top:75px;">
                  @for ($i = 1; $i <= 8; $i++)
                    <li><a href="{{URL::route('editSection', array('section' => "AC".$i))}}">AC{{$i}}</a></li>
                  @endfor
                </ul>
              </li>   
            </ul>

		@endif
        <li><a href="{{route('achievement')}}">Achievement</a></li>
        <li><a href="{{route('help')}}">Help</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <!-- Authentication Links -->
        @if (Auth::guest())
          <li><a href="{{ route('login') }}">Login</a></li>
          <li><a href="{{ route('register') }}">Register</a></li>
        @else
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
              {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
              <li>
                <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
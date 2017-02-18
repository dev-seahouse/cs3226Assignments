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
        <li><a href="{{route('create')}}">Create New Student</a></li>
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
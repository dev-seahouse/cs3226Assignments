<?php
$uri = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-inverse" role="navigation">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand <?php 
                // make navbar-brand active if current uri is index page
                if ($uri === '/') { 
                  echo ' navbar-brand-active'; 
                } ?>
                " href="{{route('index')}}">
        <span><img src="{{ URL::asset('img/omega-lightblue.png') }}" id="brandImage"></span> CS3233 Ranklist 2017
      </a>
    </div>

    <div class="collapse navbar-collapse" id="navbar-collapse">
      <p class="navbar-text">
        <!--this is to create more space between brand and list-->
      </p>
      <ul class="nav navbar-nav">
        <?php
        // add detail mode to navbar if current uri is student details page
        if (strpos($uri, '/student/') !== false) {
          echo '<li class="active"><a>Detail Mode</a></li>';
        } ?>
        <li><a href="{{route('help')}}">Help</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="{{route('login')}}">Sign In</a></li>
        <li class="dropdown">
        </li>
      </ul>
    </div>
  </div>
</nav>
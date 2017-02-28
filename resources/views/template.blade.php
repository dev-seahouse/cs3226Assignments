<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS3233 Ranklist 2017</title>
    <link rel="icon" type="image/png" href="{{ URL::asset('img/omega.png') }}">
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
  </head>
  <body>
    @include('navbar')
    @yield('main') <!-- Blade command: include section from child file -->
    @include('footer') <!-- Blade command: include other blade file -->

    <!--bootstrap must come before datatables in order to collapse navbar (conflicts)-->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>-->

    <!--the 3 scripts below are dependecies for DataTables-->
    <!--src=https://datatables.net/examples/styling/bootstrap.html-->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-92815505-1', 'auto');
      ga('send', 'pageview');
    </script>
  </body>
</html>

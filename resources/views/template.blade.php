<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CS3233 Ranklist 2017</title>
    <link rel="icon" type="image/png" href="{{ URL::asset('img/omega.png') }}">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
  </body>
</html>

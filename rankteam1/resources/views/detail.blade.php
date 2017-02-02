@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <?php
    var_dump($student);
    echo '<br>';
  ?>
  <p>This page will show the details of student with this id = insert. 
  </p>
@stop
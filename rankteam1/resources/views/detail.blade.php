@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
  <p>This page will show the details of student with this id = {{ $id }}.
  </p>
@stop
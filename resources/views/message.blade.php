@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  @if (Session::has('message'))
    <div id="success-alert" class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      {!! session('message') !!}
    </div>
  @endif
  
  <h1 class="text-center no-margin">{{__('messages.messageBoard')}}</h1>
  <br>
  <div class="row">
    @if (Auth::user()->role == 'student')
    @include('studentMsg')
    @endif
    @if (Auth::user()->role == 'admin')
    @include('adminMsg')
    @endif
  </div>
</div>
@stop
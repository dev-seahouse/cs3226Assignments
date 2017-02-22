@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
  <h1 class="text-center no-margin">Achievement Board</h1>
  <br>
  <div class="row">
    <div class="col-xs-1 col-sm-1 col-md-2"></div>
    <div class="col-xs-10 col-sm-10 col-md-8">
      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @include('acBoard', array('id' => 1, 'point' => 1, 'sectionClass' => 'ac1', 'headingId' => 'heading1', 'collapseId' => 'collapse1'))
        @include('acBoard', array('id' => 2, 'point' => 1, 'sectionClass' => 'ac2', 'headingId' => 'heading2', 'collapseId' => 'collapse2'))
        @include('acBoard', array('id' => 3, 'point' => 1, 'sectionClass' => 'ac3a', 'headingId' => 'heading3', 'collapseId' => 'collapse3'))
        @include('acBoard', array('id' => 3, 'point' => 2, 'sectionClass' => 'ac3b', 'headingId' => 'heading4', 'collapseId' => 'collapse4'))
        @include('acBoard', array('id' => 3, 'point' => 3, 'sectionClass' => 'ac3c', 'headingId' => 'heading5', 'collapseId' => 'collapse5'))
        @include('acBoard', array('id' => 4, 'point' => 1, 'sectionClass' => 'ac4a', 'headingId' => 'heading6', 'collapseId' => 'collapse6'))
        @include('acBoard', array('id' => 4, 'point' => 2, 'sectionClass' => 'ac4b', 'headingId' => 'heading7', 'collapseId' => 'collapse7'))
        @include('acBoard', array('id' => 4, 'point' => 3, 'sectionClass' => 'ac4c', 'headingId' => 'heading8', 'collapseId' => 'collapse8'))
        @include('acBoard', array('id' => 5, 'point' => 1, 'sectionClass' => 'ac5', 'headingId' => 'heading9', 'collapseId' => 'collapse9'))
        @include('acBoard', array('id' => 6, 'point' => 1, 'sectionClass' => 'ac6', 'headingId' => 'heading10', 'collapseId' => 'collapse10'))
        @include('acBoard', array('id' => 7, 'point' => 1, 'sectionClass' => 'ac7a', 'headingId' => 'heading11', 'collapseId' => 'collapse11'))
        @include('acBoard', array('id' => 7, 'point' => 2, 'sectionClass' => 'ac7b', 'headingId' => 'heading12', 'collapseId' => 'collapse12'))
        @include('acBoard', array('id' => 7, 'point' => 3, 'sectionClass' => 'ac7c', 'headingId' => 'heading13', 'collapseId' => 'collapse13'))
        @include('acBoard', array('id' => 7, 'point' => 4, 'sectionClass' => 'ac7d', 'headingId' => 'heading14', 'collapseId' => 'collapse14'))
        @include('acBoard', array('id' => 7, 'point' => 5, 'sectionClass' => 'ac7e', 'headingId' => 'heading15', 'collapseId' => 'collapse15'))
        @include('acBoard', array('id' => 7, 'point' => 6, 'sectionClass' => 'ac7f', 'headingId' => 'heading16', 'collapseId' => 'collapse16'))
        @include('acBoard', array('id' => 8, 'point' => 1, 'sectionClass' => 'ac8', 'headingId' => 'heading17', 'collapseId' => 'collapse17'))
      </div> <!-- end of multi panel -->
    </div>
    <div class="col-xs-1"></div>
  </div>
</div>
<br>
@stop
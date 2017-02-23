@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<div class="container-fluid">
	 <div class="form-group">
  {!! Form::open(['url' => 'editAllStudent/'.$section, 'method' => 'post']) !!}
  <!-- http://stackoverflow.com/questions/28028996/laravel-passing-variable-from-forms 參考-->
  	{!! Form::hidden('studentCount', $studentCount) !!}
    {!! Form::label($section, $component.' '.$week.' Scores:', ['class' => 'control-label']) !!}<br>
    <?php
    	$fields=array();
    	for($i=1; $i <= $studentCount; $i++){
    		array_push($fields,$section."_".$i);
    	}
    ?>
    <?php
			$hasRequiredError = false;
			foreach ($fields as $field) {
			  if ($errors->has($field)) {
			    $hasFormatError = true;
			    if (strpos($errors->get($field)[0], 'required') !== false) {
			        $hasRequiredError = true;
			    }
			  }
			}
    ?>
    @include('invalidErrorGroup', array('comp'=>$component, 'fields'=>$fields))
    @for ($i = 0; $i < $studentCount; $i++)
	    <br>
	    <div class="col-md-2 ">{{$i+1}}</div>
	    <div class="col-md-4 ">{{$students[$i]->name}}</div>
	    <div class="col-md-3 {{ $errors->has($section."_".($i+1)) ? 'has-error' : '' }}">{!! Form::text($section.'_'.($i+1),$hasRequiredError==true ? "": ($sectionScore[$i][0]->score ==null   ? ($component=='MC' ? 'x.y' : ($component=='TC' ? 'xy.z' : ($component=='HW' ? 'x.y' : ($component=='BS' ? 'x' : ($component=='KS' ? 'x' : 'x'))))) : ($sectionScore[$i][0]->score)) , ['class' => 'form-control']) !!}</div><br><br>
  	@endfor
  	</div><br><br>
  <div class="form-group"> {{-- Don't forget to create a submit button --}}
    {!! Form::submit('Update', ['class' => 'form-control btn btn-primary']) !!}
  </div>
  {!! Form::close() !!}
</div>
@stop

@extends('template') <!-- use the SAME template -->
@section('main') <!-- also a section called main but different content -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/darkroom.css') }}" />
<script src="{{ asset('js/fabric.js') }}"></script>
<script src="{{ asset('js/darkroom.js') }}"></script>
<div class="container-fluid"> 
  <h2 align="center">CREATE STUDENT</h2>
  {!! Form::open(['url' => 'createStudent', 'method' => 'put', 'files' => true]) !!}
  {{ csrf_field() }}
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
      <div class="container-fluid">
        <div class="form-group">
          {!! Form::label('nick', 'Nick name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'nick'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('nick', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('name', 'Full name:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'name'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('name', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('kattis', 'Kattis account:', ['class' => 'control-label']) !!}
          @include('invalidError', array('field'=>'kattis'))
          <div class="{{ $errors->has('nick') ? 'has-error' : '' }}">{!! Form::text('kattis', null, ['class' => 'form-control']) !!}</div>
        </div>
        <div class="form-group">
          {!! Form::label('nationality', 'Nationality:', ['class' => 'control-label']) !!}
          {!! Form::select('nationality', array('SGP' => 'SGP - Singaporean', 'CHN' => 'CHN - Chinese', 'VNM' => 'VNM - Vietnamese', 'IDN' => 'IDN - Indonesian', 'JPN' => 'JPN - Japanese', 'AUS' => 'AUS - Australian', 'GER' => 'GER - German', 'OTH' => 'Other Nationality')) !!}
        </div>
        <div class="form-group">
          <!--{!! Form::label('profile_pic', 'Profile picture:', ['class' => 'control-label']) !!}-->
		    <label for="profile_pic" class="control-label">Profile picture: (Click save to confirm)</label>
          @include('invalidError', array('field'=>'profile_pic'))
          @include('invalidError', array('field'=>'fileURL'))
		    <input name="profile_pic" type="file" id="profile_pic" onchange="readURL(this)"><br><br><br>
        <div id="darkroom-content">
          <img id="editImage" src="#" alt="your image"/>
          <input name="fileURL" type="hidden" id="fileURL" onchange="readURL(this)">
        </div>
        
        </div><br>
        <div class="form-group">
          {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
        </div>
      </div>
    </div>
    <div class="col-sm-1"></div>
  </div>
  {!! Form::close() !!}
</div>
<script>
function resetImage() {
  $('#darkroom-content').html('<img id="editImage" src="#"/><input name="fileURL" type="hidden" id="fileURL" onchange="readURL(this)">');
}

var prevImage = null;
function readURL(input) {
	if (input.files && input.files[0]) {
    if (prevImage == null) prevImage = $('#profile_pic').val();
    else if (prevImage != $(input).val()) resetImage();
    
		var reader = new FileReader();

		reader.onload = function (e) {
      $('#editImage').attr('src', e.target.result);
      $('.darkroom-toolbar').remove();
      $('.darkroom-image-container').remove();
      var dkrm = new Darkroom('#editImage', {
        // Size options
        minWidth: 100,
        minHeight: 100,
        maxWidth: 600,
        maxHeight: 500,

        backgroundColor: '#000',
        // Plugins options
        plugins: {
          save: {
            callback: function() {
              this.darkroom.selfDestroy(); // Cleanup
              let newImage = dkrm.canvas.toDataURL();
              $('#fileURL').val(newImage);
            }
          },
          crop: {
            quickCropKey: 67, //key "c"
            //minHeight: 50,
            //minWidth: 50,
            //ratio: 4/3
            callback: function() {
              let newImage = dkrm.canvas.toDataURL();
              $('#fileURL').val(newImage);
            }
          }
        },
        // Post initialize script
        initialize: function() {
          var cropPlugin = this.plugins['crop'];
          // cropPlugin.selectZone(170, 25, 300, 300);
          cropPlugin.requireFocus();
        }
      });
		};

		reader.readAsDataURL(input.files[0]);
	}
}
</script>
@stop

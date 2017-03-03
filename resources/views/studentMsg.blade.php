<div class="form-group">
  {!! Form::open(['url' => 'editMessage', 'method' => 'post']) !!}
  <?php
  $msgCount = sizeof($messages);
  if ($msgCount == 0) {
    $std_message = '';
    $std_reply = '';
  } else {
    $std_message = $messages[0]->message;
    $std_reply = $messages[0]->reply;
  }
  ?>
  <div class='row'>
    <div class='col-xs-1'></div>
    <div class='col-xs-10'> <!-- outer div -->
      {!! Form::hidden('id', $id) !!}
      {!! Form::hidden('messageCount', $msgCount) !!}
      <div class='col-xs-12 col-md-6'>
        {!! Form::label('messagelabel', 'Message:', ['class' => 'control-label']) !!}
        @include('invalidError', array('field'=>'message'))
        <div class="{{ $errors->has('message') ? 'has-error' : '' }}">{!! Form::textarea('message', $std_message, ['class' => 'form-control', 'rows' => 3]) !!}</div>
      </div>
        <div class='col-xs-12 col-md-6'>
        {!! Form::label('replylabel', 'Reply:', ['class' => 'control-label']) !!}
        <div class="{{ $errors->has('reply') ? 'has-error' : '' }}">{!! Form::textarea('reply', $std_reply, ['readonly', 'class' => 'form-control', 'rows' => 3]) !!}</div>
      </div>
    </div> <!-- outer div -->
  </div>
</div>
<br>
<div class="form-group">
  {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
</div>
<div class="form-group">
  {!! Form::open(['url' => 'editReplies', 'method' => 'post']) !!}
  <div class='row'>
    <div class='col-xs-1'></div>
    <div class='col-xs-10'> <!-- outer div -->
      @if (count($errors) > 0)
      <div class='row'>
        <div class="alert alert-danger">
          <ul>
            <li>Replies can only have max 255 characters</li>
          </ul>
        </div>
      </div>
      @endif
      <?php $i = 1; $msgCount = sizeof($messages); ?>
      @if ($msgCount > 0)
      {!! Form::hidden('messageCount', $msgCount) !!}
      @foreach ($messages as $message)
      {!! Form::hidden('id'.$i, $message->id) !!}
      <div class='col-xs-12 col-md-6'>
        {!! Form::label('messagelabel', 'Message from: '.$message->name, ['class' => 'control-label']) !!}
        {!! Form::textarea('message'.$i, $message->message, ['readonly', 'class' => 'form-control', 'rows' => 3]) !!}
      </div>
      <div class='col-xs-12 col-md-6'>
        {!! Form::label('replylabel', 'Reply to: '.$message->name, ['class' => 'control-label']) !!}
        <div class="{{ $errors->has('reply'.$i) ? 'has-error' : '' }}">{!! Form::textarea('reply'.$i, $message->reply, ['class' => 'form-control', 'rows' => 3]) !!}</div>
      </div>
      <?php $i++; ?>
      @endforeach
      @else
      <h4 align="center">You have no messages.</h4>
      @endif
    </div> <!-- outer div -->
  </div>
</div>
<br>
@if ($msgCount > 0)
<div class="form-group">
  {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary btn-fixed-width center-block']) !!}
</div>
@endif
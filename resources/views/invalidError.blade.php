@if (($errors)->has($field)) 
<div class="alert alert-danger">
  <ul>
    @foreach ($errors->get($field) as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
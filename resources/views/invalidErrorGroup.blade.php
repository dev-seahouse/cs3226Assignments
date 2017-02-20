<?php
$hasError = false;
foreach ($fields as $field) {
  if ($errors->has($field)) {
    $hasError = true;
    break;
  }
}
?>

@if ($hasError) 
<div class="alert alert-danger">
  <ul>
    Mini Contest scores should range from 0 to 4, with increments of 0.5, or set as "x.y".
  </ul>
</div>
@endif
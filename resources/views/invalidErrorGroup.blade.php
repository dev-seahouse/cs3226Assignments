<?php
$hasError = false;
foreach ($fields as $field) {
  if ($errors->has($field)) {
    $hasError = true;
    break;
  }
}
?>

@if($hasError) 
<div class="alert alert-danger">
  <ul>
    <?php
    switch ($comp) {
      case 'MC':
        echo 'Mini Contest scores should range from 0 to 4, with increments of 0.5, or set as "x.y".';
        break;
      case 'TC':
        echo 'Team Contest scores should range from 0 to 10.5 for Midterm TC and 0 to 13.5 for Final TC, or set as "xy.z".';
      default:
    }
    ?>
  </ul>
</div>
@endif
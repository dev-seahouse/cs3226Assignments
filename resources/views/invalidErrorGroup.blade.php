<?php
$hasFormatError = false;
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

@if($hasFormatError || $hasRequiredError) 
<div class="alert alert-danger">
  <ul>
    @if($hasRequiredError)
    <?php
      switch ($comp) {
        case 'MC':
          echo '<li>Mini Contest scores are required, or set as "x.y"</li>';
          break;
        case 'HW':
          echo '<li>Homework scores are required, or set as "x.y"</li>';
          break;
        case 'BS':
          echo '<li>Problem Bs scores are required, or set as "x"</li>';
          break;
        case 'KS':
          echo '<li>Kattis Sets scores are required, or set as "x"</li>';
          break;
        case 'AC':
          echo '<li>Achievements scores are required, or set as "x"</li>';
          break;
        default:
          // should not happen
      }
      ?>
    @endif
    @if($hasFormatError)
      <?php
      switch ($comp) {
        case 'MC':
          echo '<li>Mini Contest scores should be between 0 to 4, with increments of 0.5</li>';
          break;
        case 'HW':
          echo '<li>Homework scores should be between 0 to 1.5, with increments of 0.5</li>';
          break;
        case 'BS':
          echo '<li>Problem Bs scores should be 0 or 1</li>';
          break;
        case 'KS':
          echo '<li>Kattis Sets scores should be 0 or 1</li>';
          break;
        case 'AC':
          if ($errors->has('AC1') || $errors->has('AC2') || $errors->has('AC5') || $errors->has('AC6') || $errors->has('AC8')) {
            echo '<li>Achievements 1, 2, 5, 6 and 8 scores should be 0 or 1</li>';
          }
          if ($errors->has('AC3') || $errors->has('AC4')) {
            echo '<li>Achievements 3 and 4 scores should be between 0 to 3</li>';
          }
          if ($errors->has('AC7')) {
            echo '<li>Achievement 7 scores should be between 0 to 6</li>';
          }
          break;
        default:
          // should not happen
      }
      ?>
    @endif
  </ul>
</div>
@endif
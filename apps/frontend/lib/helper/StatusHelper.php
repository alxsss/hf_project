<?php
use_helper('I18N');
function status_date($time_u, $time_fjy)
{
  $posted_display = $time_fjy;//$status->getCreatedAt('F j, Y');
  $elapsed_time = time()-$time_u;
  if ($elapsed_time < (60*60*24))
   {
      // if elapsed time is less than a day, use elapsed time treatment
      $elapsed_hours = floor($elapsed_time / (60 * 60));
      $elapsed_time -= $elapsed_hours * 60 * 60;
      $elapsed_minutes = floor($elapsed_time / (60));
      $posted_display = ($elapsed_hours > 0)? $elapsed_hours.__(' hr ').$elapsed_minutes.__(' min ago'): $elapsed_minutes.__(' min ago');
    }
   return __($posted_display);
}
?>

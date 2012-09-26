<?php use_helper('User') ?>
<table>
<tr>
<td>
 <?php echo link_to_user_interested_video($sf_user, $video)?>  
 </td>
 <td>
<div class="interested_mark" id="mark_videos<?php echo $video->getId() ?>">
 (<?php echo $video->getVote() ?>)</div>
</td>
</tr>
</table>
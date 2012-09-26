<?php use_helper('Global', 'I18N', 'Text', 'Status','Date') ?>
<div id="updates_left_column">
 <?php include_component('friends', 'ulinks')?>
 <?php include_partial('friends/ad200x200')?>
</div>
<div id="right_column_user">
  <div id="user_rates">
  <form action="<?php echo url_for('@delete_rating')?>" method="post" >
  <table width="100%" cellpadding="1" cellspacing="1" class="readMessage">
        <tr> 
      <th width="30%" align="center">
	    <input type="checkbox" value="" name="contacts" id="toggle_all_checkbox" onclick="toggle_all(true);" class="inputcheckbox"/>
      </th>
	  <th width="30%" align="center"><?php echo __('photo')?></th>
	  <th width="30%" align="center"><?php echo __('rate')?></th>
	  <th width="30%" align="center"><?php echo __('user')?></th>	  
    </tr>
    <?php foreach($rated_photos_pager->getResults() as $rated_photo): ?>
      <?php $guestUser=sfGuardUserPeer::retrieveByPk($rated_photo->getUserId()); ?>
	  <?php $photo=$guestUser->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';}?>
      <tr class="inbox_message">
        <td class="inbox_checkbox" align="center"><input type="checkbox" value="<?php echo $rated_photo->getPhotoId()?>" name="markdel[<?php echo $rated_photo->getUserId()?>]" id="markdel" class="inputcheckbox"/></td>
        <td width="30%" align="center">	     
		    <a href="<?php echo url_for('photos/show?id='.$rated_photo->getPhotoId())?>">	        
	          <?php echo image_tag('/uploads/assets/photos/thumbnails/'.$rated_photo->getPhoto()->getFilename(), 'alt=no img  class=user_rated_photo')?>		      
		    </a>			     	
	    </td>
        <td width="30%" align="center">
	      <?php  $rated_photo->getRateString(); ?>
	      <div class="rate_time">(<?php echo status_date($rated_photo->getCreatedAt('U'), format_date($rated_photo->getCreatedAt(), 'p'))?>)  </div>
	    </td>
	    <td width="30%" align="center">
	      <div class="inbox_username"><?php  echo link_to($guestUser, 'user/'.$guestUser ) ?></div>
		  <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="clear:both; " alt=no img'), 'user/'.$guestUser) ?>		 
	    </td>
      </tr>	
	  <?php if($rated_photo->getChecked()==0):?>
	    <?php $rated_photo->setChecked(1)?>
		<?php $rated_photo->save_checked()?>
	  <?php endif;?>
    <?php endforeach; ?>
    <tr>
      <td colspan="4">
         <input type="submit" name="delete" class="reply_to_message" value="<?php echo __('Delete Marked')?>" />	
      </td>
    </tr>
  </table>
  </form>
  <?php if ($rated_photos_pager->haveToPaginate()):?>
  <div class="pagination">
   <div id="photos_pager">
     <?php echo pager_navigation($rated_photos_pager, '@ratings') ?>
   </div>
  </div>
   <?php endif;?>
</div>
</div>
<?php include_partial('friends/horizontal_ad')?>
<script type="text/javascript">
function toggle_all(clicked)
{
  _toggle_all(clicked,'toggle_all_checkbox','user_rates');
  return false;
}
function _toggle_all(clicked,master_str,chooser_str)
{
  var master=document.getElementById(master_str);
  if(clicked)
  {
    i=1;
	var new_value=master.checked;
  }
  else
  {
    i=0;
	var new_value=!master.checked;
  }
  var chooser=document.getElementById(chooser_str);
  var all_inputs=chooser.getElementsByTagName('input');
  for(i=0;i<all_inputs.length;i++)
  {
    if(all_inputs[i].type=='checkbox')
	{
	  all_inputs[i].checked=new_value;
	}
  }
  return false;
}
</script>

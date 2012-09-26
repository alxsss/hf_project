<?php use_helper('Global', 'I18N', 'Text', 'Date') ?>
<div class="ifp_nav">
    <ul>
          <li><?php echo link_to(__('inbox'), '@user_inbox') ?></li>
          <li class="last_nb selected"><?php echo link_to(__('sentbox'), '@user_sentbox') ?></li>
        </ul>
  </div>
<div id="messages_inbox">
  <?php if(count($msgs)>0):?>
  <form action="<?php echo url_for('@delete_messagesfromsentbox')?>" method="post" >
 <table width="100%" cellpadding="1" cellspacing="1" class="readMessage">
  <tr>
    <th>
      <input type="checkbox" value="" name="contacts" id="toggle_all_checkbox" onclick="toggle_all(true);" class="inputcheckbox"/>
    </th>
	<th><?php echo __('To')?></th>
	<th><?php echo __('Subject')?></th>
	<th><?php echo __('Date')?></th>
	<th><?php //echo __('Action')?></th>
  </tr>
  <?php foreach ($msgs as $i=>$msg): ?>
    <?php $messages_pager=MessagePeer::getMessagesPager($msg->getSubject(), $msg->getToUserid(), $user_id, 1);//change getFromUserId to getToUserid because this function uses this->user_id as to_userid and fromuserid param is used symmetrically with to_userdi?>    
    <tr class="inbox_message">
      <td class="inbox_checkbox <?php echo fmod($i, 2) ? 'even' : 'odd' ?>"><input type="checkbox" value="<?php echo $msg->getId()?>" name="markdel[]" id="markdel" class="inputcheckbox"/></td>
	  <td width="50px" align="center" class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?>">
	    <div class="inbox_username"><?php echo link_to($msg->getsfGuardUserRelatedByToUserid(), 'message/show?id='.$msg->getId().'&fromuserid='.$msg->getToUserid().'&page='.$messages_pager->getLastPage()) ?>
        </div>
        <?php $photo=$msg->getsfGuardUserRelatedByToUserid()->getProfile()->getPhoto();  if(empty($photo)){$photo='no_pic.gif';} ?>
	    <?php  echo link_to(image_tag('/uploads/assets/avatars/thumbnails/'.$photo, 'style="clear:both; " alt=no img'), 'message/show?id='.$msg->getId().'&fromuserid='.$msg->getToUserid().'&page='.$messages_pager->getLastPage()) ?>
	  </td>
      <td class="inbox_subject <?php echo fmod($i, 2) ? 'even' : 'odd' ?>"><?php echo link_to($msg->getSubject(), 'message/show?id='.$msg->getId().'&fromuserid='.$msg->getToUserid().'&page='.$messages_pager->getLastPage()) ?>
    	  <span class="message_text_insubject"><?php echo link_to(truncate_text($msg->getMsgtext(), 80-strlen($msg->getSubject())), 'message/show?id='.$msg->getId().'&fromuserid='.$msg->getToUserid().'&page='.$messages_pager->getLastPage()) ?></span></td>
	  <td class="<?php echo fmod($i, 2) ? 'even' : 'odd' ?> inbox_date"><?php echo format_date($msg->getCreatedAt(),'f')?></td>	
	  <td class="inbox_action <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">  
	    <?php echo link_to(__('Delete'), 'message/deletefromsentbox?id='.$msg->getId().'&touserid='.$msg->getToUserid(), array('post' => true, 'confirm' => __('Are you sure?'))) ?>
      </td>
    </tr>
  <?php endforeach; ?>
  <tr><td colspan="5">
    <input type="hidden" name="fromfolder" value="sentbox" />
	<input type="submit" name="delete" class="reply_to_message" value="<?php echo __('Delete Marked')?>" />	
  </td></tr>
</table>
</form>
<?php endif;?>
</div>
<script type="text/javascript">
function toggle_all(clicked)
{
  _toggle_all(clicked,'toggle_all_checkbox','messages_inbox');
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

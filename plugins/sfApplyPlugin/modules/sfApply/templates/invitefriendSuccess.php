<?php use_helper('I18N') ?>
  <div class="sf_apply sf_apply_reset">
    <h3><?php echo __('Invite Your Friends')?></h3>
    <?php echo __('From')?>: <?php echo $name?>
    <form method="POST" action="<?php echo url_for('@invitefriend') ?>" name="sf_apply_invitefriend_form" id="sf_apply_invitefriend_form">
     <table>
      <tr>
        <td>
		  <?php echo $form['recepient_email']->renderLabel() ?><br>
		  <div class="invite_friend_help"><?php echo $form['recepient_email']->renderHelp()?></div>
		</td>
        <td>  <div id="invite_friend_addressbook">
    <a href="javascript:invitefriend('pab','<?php echo url_for("@openInviterHome")?>',600,680,0)"><?php echo __('Insert from my Address Book')?></a> 
  </div>

          <?php echo $form['recepient_email']->renderError() ?>
          <?php echo $form['recepient_email'] ?>		  
        </td>
      </tr>
      <tr>
        <td>
		  <?php echo $form['personal_message']->renderLabel()?><br>
		  <div class="invite_friend_help"><?php echo $form['personal_message']->renderHelp()?></div>
		</td>
        <td>
          <?php echo $form['personal_message']->renderError() ?>
          <?php echo $form['personal_message'] ?>		  
        </td>
      </tr>
	 </tbody>
  </table>  
    <input type="submit" value="<?php echo __('Invite') ?>">
    <?php echo link_to(__('Cancel'), 'sfApply/resetCancel') ?>
    </form>
  </div>
<script type="text/javascript">
function invitefriend(n,u,w,h,x) {
	remote=window.open(u,n,'width='+w+',height='+h+',resizable=yes,scrollbars=yes,status=0');
	remote.opener = self;
	if (remote !== null) {
		if (remote.opener === null ){
			remote.opener = self;
		}
	}
	if (x==1) {
		return remote;
	}
}
</script>

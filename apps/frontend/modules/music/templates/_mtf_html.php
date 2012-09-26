<?php use_helper('Javascript', 'Validation', 'Form') ?>
<div id="mtf-overlay"> 
  <div class="twm-mtf">
    <div id="mtf-form">
      <div class="bd">
		
   	    <?php  echo form_remote_tag(array('url'=> '@mtf_email', 'update' => 'twm-mtf',  'success'=>'mtfSuccess()',)) ?>
		<button onClick= "javascript:MTF.close();" class="btn-x"></button>
		  <?php echo input_hidden_tag('mtf-title')?> 
		  <?php echo input_hidden_tag('mtf-url')?> 
		  <span class="title" id="mtf-title"></span>
		  <span class="date"><?php $date=getdate(time()); echo $date['mon'].'/'.$date['mday'].'/'.$date['year'];?></span>
		  <div id="mtf-error"></div>
		  <label for="twm-email-to" id="labelremail" class="email_to">Email to:</label>
		  <em>Enter email addresses, separated by commas. Max 200 chars.</em>
		  <input type="text" class="textinput" id="sfApplyInviteFriend_recepient_email"  name="remail" value="" maxlength="200" /> 
		  <a href="javascript:invitefriend('pab','/grabcontact',600,580,0)">Insert from my Address Book</a> 
		  <label for="twm-email-address" id="labelsemail">Your Email Address:</label>
		  <input type="text" class="textinput"  id="twm-email-address" name="semail" value="<?php if($sf_user->isAuthenticated())echo $sf_user->getEmail(); ?>" />
          <label for="twm-form-personal-msg" class="personal_message">Add a personal message: (optional)</label>
		  <textarea id="twm-form-personal-msg" name="pmsg" wrap="hard"></textarea>
		  <div class="mtf-buttons">
            <button type="submit" class="btn-send" onClick="return mtfEmailValidate();" name="twm-form-send" id="demo-run">Submit</button>
			<button onClick="javascript:mtfEmailResetColor(); return MTF.close(); " class="btn-cancel">Cancel</button>
	     </div>
	    </form>
      </div>
      <div class="ft">
        <div class="twmcopyright">Copyright &copy; 2009 fmpsv. All Rights reserved</div>
      </div>
    </div>
    <div id="mtf-success">
      <h3>Your message has been successfully sent!</h3>
      <button onClick="javascript:MTF.close();" class="btn-close">Close</button>
    </div>
  </div>
</div>
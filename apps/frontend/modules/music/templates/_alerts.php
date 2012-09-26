<?php use_helper('Javascript', 'Validation') ?>
<?php use_helper('Cryptographp');?>
<div id="twm-alerts">
		<div class="hd">
			<h2>Get email and mobile alerts</h2>
		</div>
		<div class="bd">
           <?php  echo form_remote_tag(array('url'=> '@add_email', 'update' => 'twm-alerts',
		   'condition' => 'validate_alerts()',)) ?>
         
           <?php echo label_for('email','Email:') ?><br>
	  	   <?php echo input_auto_complete_tag('email', $sf_params->get('email'), '', 'autocomplete=off', 'use_style=true')?>
		   <br>
		   <?php echo cryptographp_picture();?>
           <?php echo cryptographp_reload();?>
		   <br>
		   <?php echo label_for('crypto','Enter security code:') ?>
		   <br>
		   <?php echo form_error('crypto') ?>
           <?php echo input_tag('crypto') ?>
		   <br>
	       <?php echo submit_tag('Submit') ?>
		  
          </form>
	    
    </div>
	<div class="ft"></div>
</div>
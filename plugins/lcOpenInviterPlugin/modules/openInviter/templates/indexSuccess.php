<?php use_helper('I18N')?>
<style>.error_list{color: #FF0000;margin-left: 20px;}</style>
<div class="open-inviter-container">
	  <h2><?php echo __('Enter your information')?></h2>
	  <form action="<?php echo url_for("openInviter/show")?>" method="post">
	    <table id="open-inviter-login">
	      <tfoot>
	        <tr>
	          <td colspan="2">
	            <input type="submit" value="<?php echo __('Submit')?>" />
	          </td>
	        </tr>
	      </tfoot>
	      <tbody>
	        <?php echo $form ?>
	      </tbody>
	    </table>
	  </form>
</div>

If you'd like to upload a video or advertise on our site, please fill out this contact form.
   
    <fieldset>
   <?php echo form_tag('content/advertise') ?>

   
      <?php use_helper('Javascript','Text','Validation') ?>
      <?php echo form_error('name') ?>
      <div class="form-row">
        <label for="username">Name:</label>
		<br>
        <?php echo input_tag('name', $sf_params->get('name')) ?>
      </div>
      <div class="form-row">
        <?php echo form_error('company') ?>
        <label for="company">Company:</label>
		<br>
        <?php echo input_tag('company', $sf_params->get('company')) ?>
      </div>
	  <div class="form-row">
        <?php echo form_error('email') ?>
        <label for="email">Email:</label>
		<br>
        <?php echo input_tag('email', $sf_params->get('email')) ?>
      </div>
	  <div class="form-row">
        <?php echo form_error('phone') ?>
        <label for="phone">Phone:</label>
		<br>
        <?php echo input_tag('phone', $sf_params->get('phone')) ?>
      </div>
    <div class="form-row">
        <?php echo form_error('comment') ?>
        <label for="comment">Brief description of you company or your comments</label>
		<br>
        <?php echo textarea_tag('comment','','size=30x10') ?>
      </div>
  
 
  <?php echo input_hidden_tag('referer', $sf_request->getAttribute('referer')) ?>
  <?php echo submit_tag('Submit') ?> 
  </form>
  </fieldset>
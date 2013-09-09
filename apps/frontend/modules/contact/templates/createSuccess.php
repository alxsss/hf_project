<?php use_helper('I18N') ?>
<div class="edit_left_column">
  <?php $advertise = $form->getObject() ?>
  <?php echo __('Please fill out this contact form or email us at info at hemsinif dot com')?>
  <br>
  <br>
  <form action="<?php echo url_for('contact/create') ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table>
    <tfoot>
      <tr>
        <td colspan="2">
        <input type="submit" value="<?php echo __('Submit')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><label for="advertise_name"><?php echo __('Name')?></label></th>
        <td>
          <?php echo $form['name']->renderError() ?>
          <?php echo $form['name'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="advertise_company"><?php echo __('Company')?></label></th>
        <td>
          <?php echo $form['company']->renderError() ?>
          <?php echo $form['company'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="advertise_email"><?php echo __('Email')?></label></th>
        <td>
          <?php echo $form['email']->renderError() ?>
          <?php echo $form['email'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="advertise_phone"><?php echo __('Phone')?></label></th>
        <td>
          <?php echo $form['phone']->renderError() ?>
          <?php echo $form['phone'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="advertise_comment"><?php echo __('Comment')?></label></th>
        <td>
          <?php echo $form['comment']->renderError() ?>
          <?php echo $form['comment'] ?>
        </td>
      </tr>
      
    </tbody>
  </table>
</form>
 </div><!-- end edit_left_column-->
  <div class="ad_right_column">
       <!-- Begin: adBrite, Generated: 2010-10-22 19:33:36  -->
<script type="text/javascript">
var AdBrite_Title_Color = '0000FF';
var AdBrite_Text_Color = '000000';
var AdBrite_Background_Color = 'FFFFFF';
var AdBrite_Border_Color = 'CCCCCC';
var AdBrite_URL_Color = '008000';
try{var AdBrite_Iframe=window.top!=window.self?2:1;var AdBrite_Referrer=document.referrer==''?document.location:document.referrer;AdBrite_Referrer=encodeURIComponent(AdBrite_Referrer);}catch(e){var AdBrite_Iframe='';var AdBrite_Referrer='';}
</script>
<script type="text/javascript">document.write(String.fromCharCode(60,83,67,82,73,80,84));document.write(' src="http://ads.adbrite.com/mb/text_group.php?sid=1790208&zs=3330305f323530&ifr='+AdBrite_Iframe+'&ref='+AdBrite_Referrer+'" type="text/javascript">');document.write(String.fromCharCode(60,47,83,67,82,73,80,84,62));</script>
<div><a target="_top" href="http://www.adbrite.com/mb/commerce/purchase_form.php?opid=1790208&afsid=1" style="font-weight:bold;font-family:Arial;font-size:13px;">Your Ad Here</a></div>
<!-- End: adBrite -->
  </div>

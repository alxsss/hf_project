<?php use_helper('I18N')?>
<div id="updates_left_column">
 <?php if($sf_user->isAuthenticated()):?> 
   <?php include_component('friends', 'ulinks')?>
 <?php else:?>
  <?php include_partial('home/inhemsinif')?>	    
<?php endif;?>
</div>
<div id="right_column_user">
  <div class="edit_left_column">
    <?php $album = $form->getObject() ?>
    <h4><?php echo __('edit album')?></h4>

<form action="<?php echo url_for('albums/update'.(!$album->isNew() ? '?id='.$album->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
  <table id="album_edit">
    <tfoot>
      <tr>
        <td colspan="2">
          &nbsp;<a href="<?php echo url_for('albums/show?id='.$album->getId()) ?>"><?php echo __('Cancel')?></a>
          <?php if (!$album->isNew()): ?>
            &nbsp;<?php echo link_to(__('Delete'), 'albums/delete?id='.$album->getId(), array('post' => true, 'confirm' => __('Are you sure?'))) ?>
          <?php endif; ?>
          <input type="submit" value="<?php echo __('Save')?>" />
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php echo $form->renderGlobalErrors() ?>
      <tr>
        <th><label for="album_title"><?php echo __('title')?></label></th>
        <td>
          <?php echo $form['title']->renderError() ?>
          <?php echo $form['title'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="album_description"><?php echo __('description')?></label></th>
        <td>
          <?php echo $form['description']->renderError() ?>
          <?php echo $form['description'] ?>
        </td>
      </tr>
      <tr>
        <th><label for="album_visibility"><?php echo __('visibility')?></label></th>
        <td>
          <?php echo $form['visibility']->renderError() ?>
          <?php echo $form['visibility'] ?>
        </td>
      </tr>
      <tr>
        <td></td>
        <td>
          <?php echo $form['user_id']->renderError() ?>
          <?php echo $form['user_id'] ?>

        <?php echo $form['id'] ?>
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


</div>

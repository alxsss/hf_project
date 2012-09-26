<?php use_helper('Date', 'Javascript', 'Form') ?>

<ul>
<?php print_r($feed); //exit;?>
  <?php foreach($feed->getItems() as $post): ?>
  <li>
    <?php if(substr($post->getLink(), -3, 3)!='mp3') continue ?>
	<?php $search_array=explode(' - ', $post->getTitle()); ?>
    <?php echo $post->getTitle() ?>
	<?php echo form_tag('playlist/list') ?>
     <?php echo input_hidden_tag('song_url', $post->getLink()) ?>
	 <?php echo input_hidden_tag('song_title', $search_array[0]) ?>
	 <?php if(array_key_exists(2, $search_array)):?> 
	   <?php echo input_hidden_tag('artist', $search_array[2]) ?>
	 <?php endif;?>
	<?php echo submit_tag('add', 'src=/images/new.png title=add to playlist') ?> 
	</form>
	<div class="playlist_explore">      
	<?php echo link_to_remote(image_tag('play.jpg'), array(
      'update' => 'user_player',
      'url'    => url_for('music/loadplaylist?song_title='.str_replace('/','^',$search_array[0]).'&song_url='.str_replace('/','^',$post->getLink())),
	  )) ?> 
    </div>
  </li>
  <?php endforeach; ?>
</ul>
<div id="user_player">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="300" height="170" id="xspf_player" align="middle">
  <param name="allowScriptAccess" value="sameDomain" />
  <param name="movie" value="/js/xspf_player.swf?song_url=&song_title=&autoload=true&autoplay=true&shuffle=true" />
  <param name="quality" value="high" />
  <param name="bgcolor" value="#e6e6e6" />
  <embed src="/js/xspf_player.swf?song_url=http://download.muzoff.ru/m3_files/114/11459/dima_bilan_-_lady_flame.mp3&song_title=better in time&autoload=true&autoplay=true&shuffle=true" quality="high" bgcolor="#e6e6e6" width="300" height="170" name="xspf_player" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div>
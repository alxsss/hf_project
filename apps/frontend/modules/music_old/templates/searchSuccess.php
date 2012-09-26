<?php use_helper('Date', 'Javascript', 'Global') ?>
 <div id="loader_bd">
    <?php echo image_tag('loader_bd.gif', 'alt=loader')?>
  </div>
<?php //if(count($feed->getItems())):?>
<?php $cnt=0;?>
<?php //print_r($xml)?>

<ul class="free_music">
  <?php foreach($feed->getItems() as $i=>$post): ?>
    <?php if(substr($post->getLink(), -3, 3)!='mp3') continue ?>
	<?php $cnt++;//count number of mp3 link?>
    <?php $search_array=explode(' - ', $post->getTitle()); ?>
    <li class="music_search_song <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">	
      <?php echo $post->getTitle() ?>
      <?php //echo $post->getLink()?>
	   <div id="play_button_<?php echo $i?>">
	   <a href="#" class="playButton"> 
	      <?php echo image_tag('transparent.gif', 'class=play_button_play alt=play title=play 
		  song_url='.str_replace('/','^',urlencode($post->getLink())).' song_title='.str_replace('/','^',urlencode($search_array[0])))
		 ?> 
	    </a>        
	 </div>	
	 
	  <?php if($sf_user->isAuthenticated()):?>
	    <?php echo form_tag('playlist/list') ?>
        <?php echo input_hidden_tag('song_url', $post->getLink()) ?>
	    <?php echo input_hidden_tag('song_title', $search_array[0]) ?>
	    <?php if(array_key_exists(2, $search_array)):?> 
	      <?php echo input_hidden_tag('artist', $search_array[2]) ?>
        <?php endif;?>
		<input type="image" name="submit" src="/images/transparent.gif"  class="add_button" title="add to playlist"/> 
	    </form>
	  <?php else:?>
	    <div>
         <a href="#" class="addButton">
		   <?php echo image_tag('transparent.gif', 'class=add_button title=add to playlist alt=add to playlist')?> 
	    </a>			
	  </div>
	  <?php endif;?>	   
     </li>
  <?php endforeach; ?>
   <!---FETCH LOCAL SONGS-->
  <?php foreach($local_songs as $i=>$post): ?>
    <?php if(substr($post->getUrl(), -3, 3)!='mp3') continue ?>
	<?php $cnt++;//count number of mp3 link?>
    <?php $search_array=explode(' - ', $post->getTitle()); ?>
    <li class="music_search_song <?php echo fmod($i, 2) ? 'even' : 'odd' ?>">	
      <?php echo $post->getTitle() ?> --  <?php echo $post->getArtist()?>
	  <div id="play_button_<?php echo $i?>">  
	   <a href="#" class="playButton"> 
	      <?php echo image_tag('transparent.gif', 'class=play_button_play alt=play title=play 
		  song_url='.str_replace('/','^',urlencode('/uploads/assets/music/'.$post->getUrl())).' song_title='.str_replace('/','^',urlencode($post->getTitle())))
		 ?> 
	  </a>   	    
     </div>	 
	  <?php if($sf_user->isAuthenticated()):?>
	    <?php echo form_tag('playlist/list') ?>
        <?php echo input_hidden_tag('song_url', $post->getUrl()) ?>
	    <?php echo input_hidden_tag('song_title', $post->getTitle()) ?>
	    <?php echo input_hidden_tag('artist', $post->getArtist()) ?>
        <input type="image" name="submit" src="/images/transparent.gif"  class="add_button" title="add to playlist"/> 
	    </form>
	  <?php else:?>
	    <div>
         <a href="#" class="addButton">
		   <?php echo image_tag('transparent.gif', 'class=add_button title=add to playlist alt=add to playlist')?> 
	     </a>			
	   </div>
	  <?php endif;?>	   
     </li>
  <?php endforeach; ?>
</ul>

 <?php $search=new Search();  $search->setQuery($query); $search->save();?>
<?php if($cnt):?> 
  <div class="pagination">
    <div id="photos_pager">
      <?php echo pager_navigation_feed($feed_pager, '@music_search?query='.$query, 'content_main_music') ?>
    </div>
  </div>
 
<?php elseif(!$page):?>
  Thank you for using our mp3 search engine. Please note that our software remembers all queries with no results and makes updates. 
  So, if you come back in a few days, most likely you will find new results for the same query.
<?php endif;?>

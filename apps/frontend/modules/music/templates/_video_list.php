<!-- video-list -->			
<div class="video-lineup">
  <h3 style="text-align:center; margin:0 0 5px 0; ">This and last weekend movies</h3>
	<div class="bd" style="height:420px">
	
	<?php
		function urlifie($title,$clipId) {
			$s = urlencode($title);
			$s = str_replace('+','-',$s);
			$s = str_replace(' ','-',$s);
			$s = strtolower($s);
			
			$urlified_link = '/' . $s . '/' . $clipId;		
			return $urlified_link;
		}		
		$num_videos=count($videos);
		if ($num_videos > 0	)
		{
	?>
		<script type="text/javascript">
			var videoData = new Array();
		</script>
		
		<ul id="video-lineup-list" style="height:420px">
			<?php
				for($i=0; $i<$num_videos;$i++) 
				{
				  //$pure_text_title = html_entity_decode($titles[$i], ENT_QUOTES);
				  $link = 'http://fmpsv.com/videos/list/v/'.($i+1);		
				  $thumbnail[$i]='/uploads/assets/videos/thumbnails/'.$videos[$i]->getFilename().'.png';
                  $titles[$i]=$videos[$i]->getTitle();		
			?>				
			<li id="twm_video<?php echo $i+1;?>" >
				<?php if (!empty($thumbnail[$i])) { ?>
				<div class="video-thumb">
	            	
					<img src="<?php echo $thumbnail[$i]; ?>" alt="<?php echo $titles[$i] ; ?>">
				</div>
				<?php } ?>
				<h3><?php echo $titles[$i]; ?></h3>
				<cite><a href="<?php //echo $videos[$i]->getUrl(); ?>"><?php //echo $videos[$i]->getUrl(); ?></a></cite>
								<!--<br><cite>Release Date:<?php //echo $videos[$i]->getReleaseDate('m/d/y'); ?></cite> -->
				<div class="buttons">
					<a onclick="mtfInitHelper(<?php echo $i ?>)" class="btn-email">E-mail</a>
					<a onclick="return YAHOO.TWM.Tools.IM.imStory('<?php echo $link;?>','');" class="btn-im">IM</a>
				</div>
				
				<script type="text/javascript">
				videoData.push({
				   link: '<?php echo $link ?>',
				   title: '<?php echo addslashes($titles[$i]); ?>',
				   thumb: '<?php echo $thumbnail[$i] ?>'
				});
				</script>
			</li>
			<?php 
				} // for 		
			} // if
			?>
		</ul>
	</div>
	
	 <?php include_partial('mtf_html') ?>
</div>
<!-- /video-list -->
<?php
global $ctx, $uce, $xml;

/*
$content = $xml->getContent($uce, 'utf-8');
$obj = simplexml_load_string($content);
$data = array();
if (is_object($obj) && $obj instanceOf SimpleXMLElement)
 {
	$data['videoList'] = $obj;	
 }
 //print_r($content);
//$xml->addMetaData($uce, 'data', $data, 'utf-8');
//
//exit;
//$clipidsdata = $ctx->getValue($uce, "ctx.titleClipidFull", "utf-8");
//
*/
$single_title=$ctx->getValue($uce, "ctx.single_title", "utf-8");
$single_source=$ctx->getValue($uce, "ctx.single_source", "utf-8");
$single_imagesrc=$ctx->getValue($uce, "ctx.single_imagesrc", "utf-8");
/*
//
$single_desc=$ctx->getValue($uce, "ctx.single_desc", "utf-8");
$single_imagex=$ctx->getValue($uce, "ctx.single_imagex", "utf-8");
$single_imagey=$ctx->getValue($uce, "ctx.single_imagey", "utf-8");
$single_LargeImageSrc=$ctx->getValue($uce, "single_LargeImageSrc", "utf-8");
$single_LargeImageX=$ctx->getValue($uce, "ctx.single_LargeImageX", "utf-8");
$single_LargeImageY=$ctx->getValue($uce, "ctx.single_LargeImageY", "utf-8");
//
*/
$clipid=$ctx->getValue($uce, 'ctx.clipid', 'utf-8');
$single_guid=$ctx->getValue($uce, 'ctx.single_guid', 'utf-8');
$link ='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                     $guid2=explode('/', $single_guid);					 
					 $guid3=$guid2[1];	
                      switch($guid3)
					   {
					    case 'ysports':
						      $guidMap ='sports';
							  break;
						case 'yfinance':
						      $guidMap= 'finance';
							  break;
						case 'yfood':
						      $guidMap ='food';
							  break;
					    case 'yhealth':
						      $guidMap ='health';
							  break;
						case 'ytech':
						      $guidMap ='tech';
							  break;
						case 'ytv':
						      $guidMap ='tv';
							  break;
						case 'yugc':
						      $guidMap ='video';
							  break;
						default:
						      $guidMap ='news';
							  break;
					    }//end of switch		
//print_r($single_guid);
//exit;
/*
 $item=$data['videoList']->item;
	$num_items=count($item);
if (isset($data['videoList']) && $data['videoList'] && $num_items > 0	)
{
*/
?>
<div id="gmy-video-news">
	<?php include 'mtf_html.php' ?>
	<script type="text/javascript">
		var videoData = new Array();
	</script>
	<ol> 	
		<li id="gmy_video<?php //echo $i;?>" <?php //if($i==0) echo 'class ="current"';?>>
			<?php if (!empty($single_imagesrc)) { ?>
			<div class="video-thumb">
				<img src="<?php echo $single_imagesrc; ?>" alt="<?php echo $single_title ; ?>">
			</div>
			<?php } ?>
			<h3><?php echo $single_title; ?></h3>
			<cite><a href="<?php echo 'http://'.$guidMap.'.yahoo.com'; ?>"><?php echo $guidMap.'.yahoo.com'; ?></a></cite>		
		</li>
	</ol>   
</div><!--end: gmy-video-news -->
<?php //} ?>
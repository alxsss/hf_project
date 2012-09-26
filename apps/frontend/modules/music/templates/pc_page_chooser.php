<?php
/*******
 * pc_data.php - renderer for page controller
 * determines which page is shown by setting a ctx var
 *
 * @author Tom Melendez <supertom@yahoo-inc.com>
 *
*******/
$dom = $GLOBALS["dom"];
$ctx = $GLOBALS["ctx"];
$uce = $GLOBALS["uce"];

$DEBUGGING=getenv('GMY_DEBUGGING');
if (!strlen($DEBUGGING)) {
	$DEBUGGING=0;
}

# these have been exported by modules we depend on...
# they are the complete xml documents as strings.  Thanks a bunch, Maple.
$feed_data = $ctx->getValue($uce, "ctx.feed_data", "utf-8");
$feed_data_string = $ctx->getValue($uce, "ctx.feed_data_string", "utf-8");
$single_data = $ctx->getValue($uce, "ctx.single_data", "utf-8");

# get vars - these come in via the rewrite rules
(isset($_GET['clipid'])) ? $clipid=$_GET['clipid'] : $clipid=''; 
(isset($_GET['url'])) ? $url=$_GET['url'] : $url=''; 

//if not valid or set, return to main (should never get here)
if (!strlen($clipid) || !is_numeric($clipid)) {
 	if ($DEBUGGING) {
		error_log("GMY: page_controller renderer - clip id not valid: *".$clipid. "* and url is *$url*");
	}
	$ctx->setValue($uce, 'ctx.whichpage', 'main', 'utf-8');
	return;
}

if (strlen($feed_data)) {
	$simple_feed=simplexml_load_string($feed_data);
	if (is_object($simple_feed) && $simple_feed instanceOf SimpleXMLElement) {
		if ($DEBUGGING) {
			error_log("GMY: page_controller renderer - feed data is valid and object");
		}
		# ok, first lets check if the clip id is in our current feed
		$item=$simple_feed->channel->item;
		$clipid_data=explode('|',$feed_data_string);
		foreach ($clipid_data as $k=>$v) {
		 	if ($DEBUGGING) {
				error_log("GMY: page_controller renderer - feed data is valid and object, in loop: $v");
			}
			if ($v==$clipid) {
			 	if ($DEBUGGING) {
					error_log("GMY: page_controller func - clip id found in data.  clipid is $clipid and url is: $url");
				}
				$ctx->setValue($uce, 'ctx.whichpage', 'main', 'utf-8');
				return;
			}
		}
		if ($DEBUGGING) {
			error_log("GMY: page_controller renderer - feed data is valid and object, clip not found: clip is: $clipid");
		}
	}
	else {
		//if we didn't get the feed data something is wrong
		if ($DEBUGGING) {
			error_log("GMY: page_controller renderer - feed data is has length, but not valid object, feed data is: $feed_data");
		}
		$ctx->setValue($uce, 'ctx.whichpage', 'expired', 'utf-8');
		return;
	}
}
else {
	//if we didn't get the feed data something is wrong
	if ($DEBUGGING) {
		error_log("GMY: page_controller renderer - feed data is has NO length - is empty: feed_data var: *$feed_data*");
	}
	$ctx->setValue($uce, 'ctx.whichpage', 'expired', 'utf-8');
	return;
}


//if we got here, we know the clip isn't from today - show either the single page or expired page
if (strlen($single_data)) {
	$simple_single=simplexml_load_string($single_data);
	if (is_object($simple_single) && $simple_single instanceOf SimpleXMLElement) {
		$item=$simple_single->item;
		if (is_object($simple_single) && count($item) && $simple_single instanceOf SimpleXMLElement) {
			$ctx->setValue($uce, 'ctx.single_title', $item->title, 'utf-8');
			$ctx->setValue($uce, 'ctx.single_desc', $item->description, 'utf-8');
			$ctx->setValue($uce, 'ctx.single_guid', $item->guid, 'utf-8');
			$ctx->setValue($uce, 'ctx.single_source', $item->source, 'utf-8');
			$ctx->setValue($uce, 'ctx.clipid', $clipid, 'utf-8');

			//export image info		
	                $image=$item->xpath(".//ymyfeeds:imagesrc");
	                $image=$image[0];        			
			
			if (!is_array($image)) {
				if ($DEBUGGING) {
					error_log("GMY: image src data not available for video: {$item->title} {$item->guid}");
				}
			}

                        $imagex=$item->xpath(".//ymyfeeds:imagex");
                        $imagex=$imagex[0];

			if (!is_array($imagex)) {
			 	if ($DEBUGGING) {
					error_log("GMY: image width data not available for video: {$item->title} {$item->guid}");
				}
			}

                        $imagey=$item->xpath(".//ymyfeeds:imagey");
                        $imagey=$imagey[0];

			if (!is_array($imagey)) {
			 	if ($DEBUGGING) {
					error_log("GMY: image height data not available for video: {$item->title} {$item->guid}");
				}
			}

			//if we have large images, use those
	                $largeimage=$item->xpath(".//ymyfeeds:LargeImageSrc");
			if (isset($largeimage[0]) && strlen($largeimage[0])) {
	                        $image=$largeimage[0];
			}
		        	
			$largeimagewidth=$item->xpath(".//ymyfeeds:LargeImageX");
			if (isset($largeimagewidth[0]) && strlen($largeimagewidth[0])) {
	                        $imagex=$largeimagewidth[0];
			}

                        $largeimageheight=$item->xpath(".//ymyfeeds:LargeImageY");
			if (isset($largeimageheight[0]) && strlen($largeimageheight[0])) {
	                        $imagey=$largeimageheight[0];
			}

			$ctx->setValue($uce, 'ctx.single_imagesrc', $image, 'utf-8');
			$ctx->setValue($uce, 'ctx.single_imagex', $imagex, 'utf-8');
			$ctx->setValue($uce, 'ctx.single_imagey', $imagey, 'utf-8');
			if ($DEBUGGING) {
				error_log("GMY: page_controller renderer - single data found and exported - clipid: $clipid and url: $url - returning 'single' ");
			}

			$ctx->setValue($uce, 'ctx.whichpage', 'single', 'utf-8');
			return;
		}
		else {
			if ($DEBUGGING) {			
			error_log("GMY: page_controller renderer 'pc_page_chooser' - single data: item failed.  single data has length, is a valid object but item failed. single_data: \n*******$single_data\n*******\n  - clipid: $clipid and url: $url - returning 'expired' ");
			}
			$ctx->setValue($uce, 'ctx.whichpage', 'expired', 'utf-8');
			return;
		}
	}
	else {
		if ($DEBUGGING) {
			error_log("GMY: page_controller renderer 'pc_page_chooser' - single data not valid.  Has length $single_data - clipid: $clipid and url: $url - returning 'expired' ");
		}
		$ctx->setValue($uce, 'ctx.whichpage', 'expired', 'utf-8');
		return;
	}
}
else {
	if ($DEBUGGING) {
		error_log("GMY: page_controller renderer 'pc_page_chooser' - single data has no length.  *$single_data* - clipid: $clipid and url: $url - returning 'expired' ");
	}
	$ctx->setValue($uce, 'ctx.whichpage', 'expired', 'utf-8');
	return;
}


?>
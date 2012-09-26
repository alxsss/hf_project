<?php 
$return_array['images'] = array_values($sf_data->getRaw('images'));
$return_array['total_images'] = $imageCount;
$return_array['description']=$description;
$return_array['title']=$title; 

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

echo json_encode($return_array);
exit;
?>

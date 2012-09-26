<?php use_helper('Object')?>
<?php echo select_tag('playlist_list', objects_for_select($playlist_list, 'getId', 'getName' ))?>
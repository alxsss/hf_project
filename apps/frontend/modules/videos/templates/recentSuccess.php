<h1>recent photos</h1>
<?php
function path2url($path)
{
        return str_replace("%2F","/",rawurlencode($path));
}
?>
<?php include_partial('list', array('photos_pager' => $photos_pager, 'rule' => 'photos/recent')) ?>
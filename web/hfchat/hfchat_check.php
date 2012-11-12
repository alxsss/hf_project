<?php
include_once dirname(__FILE__)."/hf_init.php";

$return = 0;

if ($userid > 0) {
	$return = 1;
}

if (function_exists('hooks_displaybar')) {
	$return = hooks_displaybar($return);
}

echo $return;
exit;
?>

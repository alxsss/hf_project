<?php
$arr1=array(1, 2,3, 4, 5);
print_r($arr1);
echo "\n";
$key=array_search(4,$arr1);
$arr2=array_slice($arr1,$key+1);
echo 'array2';
print_r($arr2);
echo "\n";

array_splice($arr1,$key);
echo 'array1';
print_r($arr1);
echo "\n";
$arr4=array_merge($arr2,$arr1);
print_r($arr4);
?>


<?php



$names=file('swami.txt');
// To check the number of lines



$search = array('and', 'is', 'an', 'the');
$replace = array('hungry', 'wolf', 'ate', 'mouse');
echo str_replace($search, $replace, $names);
?>


<?php



$names=file('swami.txt');
$data = "";

foreach($names as $name)
{
 $search = array('Can', 'Be', 'and', 'are', 'to', 'by', 'the', 'in', 'for', 'of', 'this', 'is', 'all', 'after','with', 'which', 'it', 'an', 'not', 'that', 'there', 'if', 'was', 'as', 'or', 'at', 'on', 'our','am', 'me');
$replace = array('±', '=', '+', '¶', '^', 'µ', 'Ø', 'Ƒ', '<', '>', '¿', 'Ü', 'ä', '¬','ñ', '»', '«', 'Õ', '§', '≤', '≥', 'Ñ', 'ë', '≡', 'æ', 'ï', 'ÿ', 'ƒ','ō', 'ã');

    $data .= str_replace($search, $replace, $name);
}
   

{
$fp = fopen("myext.txt","wb");
fwrite($fp,$data);
fclose($fp);
}
?>

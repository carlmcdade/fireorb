<?php
$md5_secret_key = '0fireme';

// returns parameters and md5 sign for 
// text generating service
function img_params($text, $size) 
{
  global $md5_secret_key;
  $p = '?text='.urlencode($text).'&size='.$size.'&a=';
  return $p.md5($md5_secret_key.$text.$size);
}
?>

<html><head><title>Font test</title></head>
<body>

<center>
<img src="./font.php<?php echo img_params('Hello World', 90);?>">
<br><br>
<img src="./font.php<?php echo img_params('Enjoy the font generating service script from', 20); ?>">
<br><br>
<a href="http://www.anyexample.com/">
<img src="./font.php<?php echo img_params('FireOrb Community Framework', 30); ?>" border="0">
</a>
</center>

</body>
</html>

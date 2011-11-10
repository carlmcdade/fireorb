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

function ByteSize($bytes) 
    {
    $size = $bytes / 1024;
    if($size < 1024)
        {
        $size = number_format($size, 2);
        $size .= ' KB';
        } 
    else 
        {
        if($size / 1024 < 1024) 
            {
            $size = number_format($size / 1024, 2);
            $size .= ' MB';
            } 
        else if ($size / 1024 / 1024 < 1024)  
            {
            $size = number_format($size / 1024 / 1024, 2);
            $size .= ' GB';
            } 
        }
    return $size;
    } 
?>

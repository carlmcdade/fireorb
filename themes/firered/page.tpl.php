<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
  <script type="text/JavaScript" src="<?php print path_to_theme(); ?>/replacement.js"></script>

</head>
<body>
<div class="wrapper">
<table border="0" cellpadding="0" cellspacing="0" id="header">
  <tr>
    <td id="logo">
      <?php if ($logo) { ?>
		  <a href="<?php print $base_path ?>" title="<?php print fo_1_text('Home') ?>">
		  
		  <img src="<?php print $logo ?>" alt="<?php print fo_1_text('Home') ?>" />
		  
		  </a>
	  <?php } ?>
      	<?php if ($site_name) { ?>
	  <h1 class='site-name'>
		<a href="<?php print $base_path ?>" title="<?php print fo_1_text('Home') ?>">
		
			<img src="<?php print path_to_theme(); ?>/font.php?a=<?php print $site_name ?>&amp;b=<?php print $site_slogan ?>" alt ="<?php print $site_name.' '.$site_slogan ?>" />
		</a>
	  </h1>
	  <?php } ?>
    </td>
    <td id="menu">
      <?php print $search_box ?>
    </td>
  </tr>
  <tr><td id="primary-menu" colspan="2"><?php if (isset($primary_links)) { ?><div id="primary"><?php print theme('links', $primary_links) ?></div><?php } ?></td></tr>
  <tr><td id="secondary-menu" colspan="2"></td></tr>    
  <tr>
    <td colspan="2"><div><?php print $header ?></div></td>
  </tr>
</table>
<div id="secondary"><?php if (isset($secondary_links)) { ?><?php print theme('links', $secondary_links) ?><?php } ?></div>
<table border="0" cellpadding="0" cellspacing="0" id="content">
  <tr>
    <?php if ($sidebar_left) { ?><td valign="top" style="width: 16em;">
    <img class="bullet-start-top" alt="" src="<?php print path_to_theme()?>/bullet-start.jpg" />
     <div id="sidebar-left">
      <?php print $sidebar_left ?>
      <div class="infoblock-left"> The <a href="http://fireorb.info">FireOrb PHP website framework</a> is distributed under the <a href="http://www.opensource.org/licenses/gpl-2.0.php">GNU General Public License (GPL)</a>.
      </div>
     </div>
    <img class="bullet-end-bot" alt="" src="<?php print path_to_theme()?>/bullet-down.jpg" />
    </td><?php } ?>
    <td valign="top">
      <?php if ($mission) { ?><div id="mission"><?php print $mission ?></div><?php } ?>
      <div id="main">
        <?php print $breadcrumb ?>
        <h1 class="title"><?php print $title ?></h1>
	<?php if ($tabs) { ?>
        <div class="tabs"><img class="bullet-start-tabs" alt="" src="<?php print path_to_theme()?>/bullet-start.jpg" /><?php print $tabs ?><div align="right"><img class="bullet-end-tabs" src="<?php print path_to_theme()?>/bullet.jpg" /></div></div>
        <?php } ?>
	<?php print $help ?>
        <?php print $messages ?>
        <?php print $content; ?>
      </div>
    </td>
    <?php if ($sidebar_right) { ?><td valign="top" style="width: 16em;">
    <img class="bullet-end-top-r" alt="" src="<?php print path_to_theme()?>/bullet-up.jpg" />
    <div id="sidebar-right">
      <?php print $sidebar_right ?>
    </div>
    <img class="bullet-start-bot-r" alt="" src="<?php print path_to_theme()?>/bullet-start.jpg" />
    </td><?php } ?>
  </tr>
</table></div>
<div class="push"></div>

<div id="footer">
  <?php print $footer_message ?>
</div>
<?php print $closure ?>
<?php
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 4);
echo '<div style="position:relative;top:-16px;margin:0;padding:0;font-size:0.8em;background:transparent;color:#999;"><div style="width:55%;float:left;text-align:right;">Page generated in '.$total_time.' seconds.'."\n";
?>
<?php echo 'Memory used' .': '.ByteSize(memory_get_usage(true)) .
"\n". '</div> <div style="float:right;text-align:right;width:42%;padding-right:10px;">FireRed theme copyright 2009 Carl McDade.  <a href="http://validator.w3.org/check?uri=referer">Valid XHTML 1.0 Strict</a></div></div>';?> 
</body>
</html>

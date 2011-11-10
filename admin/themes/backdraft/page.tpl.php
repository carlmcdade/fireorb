<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">

<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>
</head>

<body>

<div id="header"><a href="<?php print $base_path ?>" title="<?php print fo_1_text('Home') ?>"><img src="<?php print path_to_theme(); ?>/font.php?a=<?php print $site_name ?>&amp;b=<?php print $site_slogan ?>" alt ="" border="0"/></a></div>

<table border="0" cellpadding="0" cellspacing="0" id="content">
  <tr>
    <td valign="top">
      
    <div id="main">
	  <div id="top-nav">
<?php print menu_tree_admin();?>
          </div>
	  <div style="clear:both"></div>
	<h1 class="title"><?php print $title ?></h1>
	<?php print $help ?>
        <?php print $messages ?>
        <div class="tabs"><?php print $tabs ?></div>
        
        <?php print $content; ?>	
    </div>
    </td>
  </tr>
</table>

<div id="footer">
</div>
<?php print $closure ?>
</body>
</html>

<?php
$path  = ''. dirname(__FILE__);
$install_path = '';
$path_arr = explode('/',$path);
array_pop($path_arr);
$install_path = implode('/',$path_arr); 



chdir($install_path);
require($install_path.'/includes/bootstrap.inc');

fo_1_bootstrap(FO_BOOTSTRAP_FULL);
global $theme;

$return = menu_execute_active_handler();

// Menu status constants are integers; page content is a string.
if (is_int($return)) {
  switch ($return) {
    case MENU_NOT_FOUND:
      fo_1_not_found();
      break;
    case MENU_ACCESS_DENIED:
      print_r(fo_1_list_backend_themes()).'login-form.php';
      break;
    case MENU_SITE_OFFLINE:
      fo_1_site_offline();
      break;
  }
}
elseif (isset($return) && trim($return) != '') {
		print theme('page',$return).'<div id="topbar-admin">Control Panel for FireOrb'.'</div>';
}

?>
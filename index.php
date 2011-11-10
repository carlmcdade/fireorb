<?php
// $Id: index.php,v 1.90.2.1 2006/12/12 13:50:59 killes Exp $

/* FireOrb connection to Codeigniter */
//global $CI;
//$CI = require_once('./ci/fireorb/fireorb_index.php');

/**
 * @file
 * The PHP page that serves all page requests on a FireOrb installation.
 *
 * The routines here dispatch control to the appropriate handler, which then
 * prints the appropriate page.
 */

require_once './includes/bootstrap.inc';
fo_1_bootstrap(FO_BOOTSTRAP_FULL);

$return = menu_execute_active_handler();

// Menu status constants are integers; page content is a string.
if (is_int($return)) {
  switch ($return) {
    case MENU_NOT_FOUND:
      fo_1_not_found();
      break;
    case MENU_ACCESS_DENIED:
      fo_1_access_denied();
      break;
    case MENU_SITE_OFFLINE:
      fo_1_site_offline();
      break;
  }
}
elseif (isset($return)) {
  // Print any value (including an empty string) except NULL or undefined:
  print theme('page', $return);

}

fo_1_page_footer();
<?php
// $Id: cron.php,v 1.34 2005/12/31 14:18:22 dries Exp $

/**
 * @file
 * Handles incoming requests to fire off regularly-scheduled tasks (cron jobs).
 */

include_once './includes/bootstrap.inc';
fo_1_bootstrap(FO_BOOTSTRAP_FULL);

// If not in 'safe mode', increase the maximum execution time:
if (!ini_get('safe_mode')) {
  set_time_limit(240);
}

// Check if the last cron run completed
if (fo_1_variable_get('cron_busy', false)) {
  fo_1_watchdog('cron', fo_1_text('Last cron run did not complete.'), WATCHDOG_WARNING);
}
else {
  fo_1_variable_set('cron_busy', true);
}

// Iterate through the modules calling their cron handlers (if any):
module_invoke_all('cron');

// Clean up
fo_1_variable_set('cron_busy', false);
fo_1_variable_set('cron_last', time());
fo_1_watchdog('cron', fo_1_text('Cron run completed'));

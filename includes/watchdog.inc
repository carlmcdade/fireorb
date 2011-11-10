<?php
// $Id: watchdog.module,v 1.143 2006/04/13 08:25:27 killes Exp $

/**
 * @file
 * System monitoring and logging for administrators.
 *
 * The watchdog module monitors your site and keeps a list of
 * recorded events containing usage and performance data, errors,
 * warnings, and similar operational information.
 *
 * @see fo_1_watchdog().
 */

/**
 * Implementation of hook_help().
 */
function watchdog_help($section) {
  switch ($section) {
    case 'admin/help#watchdog':
      $output = '<p>'. fo_1_text('The watchdog module monitors your system, capturing system events in a log to be reviewed by an authorized individual at a later time.  This is useful for site administrators who want a quick overview of activities on their site. The logs also record the sequence of events, so it can be useful for debugging site errors.') .'</p>';
      $output .= '<p>'. fo_1_text('The watchdog log is simply a list of recorded events containing usage data, performance data, errors, warnings and operational information. Administrators should check the watchdog report on a regular basis to ensure their site is working properly.') .'</p>';
      $output .= fo_1_text('<p>You can</p>
<ul>
<li>view watchdog logs at <a href="%admin-watchdog">administer &gt;&gt; watchdog</a>.</li>
<li>view watchdog event logs at <a href="%admin-watchdog-events">administer &gt;&gt; watchdog &gt;&gt; events</a>.</li>
</ul>
', array('%admin-watchdog' => fo_1_url('admin/watchdog'), '%admin-watchdog-events' => fo_1_url('admin/watchdog/events')));
      $output .= '<p>'. fo_1_text('For more information please read the configuration and customization handbook <a href="%watchdog">Watchdog page</a>.', array('%watchdog' => 'http://fireorb.info/handbook/modules/watchdog/')) .'</p>';
      return $output;
    case 'admin/modules#description':
      return fo_1_text('Logs and records system events.');
    case 'admin/logs':
      return fo_1_text('<p>The watchdog module monitors your web site, capturing system events in a log to be reviewed by an authorized individual at a later time.  The watchdog log is simply a list of recorded events containing usage data, performance data, errors, warnings and operational information.  It is vital to check the watchdog report on a regular basis as it is often the only way to tell what is going on.</p>');
  }
}

/**
 * Implementation of hook_menu().
 */
function watchdog_menu($may_cache) {
  $items = array();

  if ($may_cache) {
    $items[] = array(
	    'path' => 'admin/logs', 
	    'title' => fo_1_text('reports and logs'),
	    'callback' => 'watchdog_overview',
	    'weight' => 100
	    );
    $items[] = array(
	    'path' => 'admin/logs/event', 
	    'title' => fo_1_text('details'),
	    'callback' => 'watchdog_event',
	    'type' => MENU_CALLBACK,
      );
  }
  return $items;
}

/**
 * Implementation of hook_cron().
 *
 * Remove expired log messages and flood control events.
 */
function watchdog_cron() {
  db_query('DELETE FROM {watchdog} WHERE timestamp < %d', time() - fo_1_variable_get('watchdog_clear', 604800));
  db_query('DELETE FROM {flood} WHERE timestamp < %d', time() - 3600);
}

/**
 * Implementation of hook_user().
 */
function watchdog_user($op, &$edit, &$user) {
  if ($op == 'delete') {
    db_query('UPDATE {watchdog} SET uid = 0 WHERE uid = %d', $user->uid);
  }
}

/**
 * Menu callback; displays a listing of log messages.
 */
function watchdog_overview() {
  $icons = array(WATCHDOG_NOTICE  => '',
                 WATCHDOG_WARNING => theme('image', 'misc/watchdog-warning.png', fo_1_text('warning'), fo_1_text('warning')),
                 WATCHDOG_ERROR   => theme('image', 'misc/watchdog-error.png', fo_1_text('error'), fo_1_text('error')));
  $classes = array(WATCHDOG_NOTICE => 'watchdog-notice', WATCHDOG_WARNING => 'watchdog-warning', WATCHDOG_ERROR => 'watchdog-error');

  $names['all'] = fo_1_text('all messages');
  foreach (_watchdog_get_message_types() as $type) {
    $names[$type] = fo_1_text('%type messages', array('%type' => fo_1_text($type)));
  }

  if (empty($_SESSION['watchdog_overview_filter'])) {
    $_SESSION['watchdog_overview_filter'] = 'all';
  }

  $form['filter'] = array(
    '#type' => 'select',
    '#title' => fo_1_text('Filter by message type'),
    '#options' => $names,
    '#default_value' => $_SESSION['watchdog_overview_filter']
  );
	
  $form['#action'] = fo_1_url('admin/logs');

  $form['submit'] = array(
													'#type'  => 'submit', 
													'#value'  => fo_1_text('Filter')
													);
  $output = fo_1_get_form('watchdog_form_overview', $form);

  $header = array(
    ' ',
    array('data' => fo_1_text('Type'), 'field' => 'w.type'),
    array('data' => fo_1_text('Date'), 'field' => 'w.wid', 'sort' => 'desc'),
    array('data' => fo_1_text('Message'), 'field' => 'w.message'),
    array('data' => fo_1_text('User'), 'field' => 'u.name'),
    array('data' => fo_1_text('Operations'))
  );

  $sql = "SELECT w.*, u.name, u.uid FROM {watchdog} w INNER JOIN {users} u ON w.uid = u.uid";
  $tablesort = tablesort_sql($header);
  $type = $_SESSION['watchdog_overview_filter'];
  if ($type != 'all') {
    $result = pager_query($sql ." WHERE w.type = '%s'". $tablesort, 50, 0, NULL, $type);
  }
  else {
    $result = pager_query($sql . $tablesort, 50);
  }

  while ($watchdog = db_fetch_object($result)) {
    $rows[] = array('data' =>
      array(
        // Cells
        $icons[$watchdog->severity],
        fo_1_text($watchdog->type),
        fo_1_format_date($watchdog->timestamp, 'small'),
        fo_1_link(truncate_utf8($watchdog->message, 56, TRUE, TRUE), 'admin/logs/event/'. $watchdog->wid, array(), NULL, NULL, FALSE, TRUE),
        theme('username', $watchdog),
        $watchdog->link,
      ),
      // Attributes for tr
      'class' => "watchdog-". preg_replace('/[^a-z]/i', '-', $watchdog->type) .' '. $classes[$watchdog->severity]
    );
  }

  if (!$rows) {
    $rows[] = array(array('data' => fo_1_text('No log messages available.'), 'colspan' => 6));
  }

  $output .= theme('table', $header, $rows);
  $output .= theme('pager', NULL, 50, 0);

  return $output;
}

function theme_watchdog_form_overview($form) {
  return '<div class="container-inline">'. form_render($form) .'</div>';
}

function watchdog_form_overview_submit($form_id, $form) {
  global $form_values;
  $_SESSION['watchdog_overview_filter'] = $form_values['filter'];
}

/**
 * Menu callback; displays details about a log message.
 */
function watchdog_event($id) {
  $severity = array(WATCHDOG_NOTICE => fo_1_text('notice'), WATCHDOG_WARNING => fo_1_text('warning'), WATCHDOG_ERROR => fo_1_text('error'));
  $output = '';
  $result = db_query('SELECT w.*, u.name, u.uid FROM {watchdog} w INNER JOIN {users} u ON w.uid = u.uid WHERE w.wid = %d', $id);
  if ($watchdog = db_fetch_object($result)) {
    $header = array(fo_1_text('Type'), fo_1_text('Date'), fo_1_text('User'), fo_1_text('Location'), fo_1_text('Referrer'), fo_1_text('Message'), fo_1_text('Severity'), fo_1_text('Hostname'));
    $data = array(fo_1_text($watchdog->type), fo_1_format_date($watchdog->timestamp, 'large'), theme('username', $watchdog), fo_1_link($watchdog->location, $watchdog->location), fo_1_link($watchdog->referer, $watchdog->referer), $watchdog->message, $severity[$watchdog->severity], $watchdog->hostname);
    $output = theme('watchdog_event', $header, $data);
  }
  return $output;
}

function theme_watchdog_event($header, $data) {
  $output = '';
  $output .= '<table class="watchdog-event">';

  $n = count($header);
  for ($i = 0; $i < $n; $i++) {
    $output .= '<tr class="' . ($i % 2 == 0 ? 'even' : 'odd') . '"><th>' . $header[$i] . '</th><td>' . $data[$i] . '</td></tr>';
  }

  $output .= '</table>';

  return $output;
}

function _watchdog_get_message_types() {
  $types = array();

  $result = db_query('SELECT DISTINCT(type) FROM {watchdog} ORDER BY type');
  while ($object = db_fetch_object($result)) {
    $types[] = $object->type;
  }

  return $types;
}
?>

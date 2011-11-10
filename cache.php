    <?php
    /*
     * See http://drupal.org/node/152983 for details!
     */
     
	//set the working directory to your Drupal root
	//chdir('/home/public_html/drupal/');
	
	//require the bootstrap include
	require_once 'includes/bootstrap.inc';
	
	//Load Drupal
	
	fo_1_bootstrap(FO_BOOTSTRAP_FULL);
	//(loads everything, but doesn't render anything)
	
	//display a node
	print '<pre>';
	print_r(node_load(12));
	print '</pre>';
     
    // only allow site administrators to visit this page:
    if (!user_access('administer site configuration'))
    {
    	fo_1_not_found();
    }
    else {
    //fo_1_clear_css_cache();
    $tables = array(
    'cache',
    'cache_content',
    'cache_filter',
    'cache_menu',
    'cache_page',
    'cache_views',
    );
    foreach ($tables as $table) {
    fo_1_cache_clear_all('*', $table, TRUE);
    }
    fo_1_set_message('Cache cleared.');
    fo_1_goto(url('admin'));
    }
    ?>

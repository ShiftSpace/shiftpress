<?php
/*
	Plugin Name: ShiftPress
	Plugin URI: http://www.shiftspace.org
	Description: ShiftSpace for Wordpress!
	Version: 1.0
	Author: C.N.
	*/

add_action('wp_head', 'shiftpressLoad');

function shiftpressLoad(){
	echo("\n\n<script type='text/javascript'
		src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/externals/mootools-1.2.3-core.js'></script>\n\n");    	  
	echo("\n\n<script type='text/javascript' src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/externals/mootools-1.2.3.1-more.js'></script>\n\n");
	echo("\n\n<script type='text/javascript' src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/builds/shiftspace.sandbox.js'></script>\n\n");	  
}
//register wordpress user in shiftspace db.
?>
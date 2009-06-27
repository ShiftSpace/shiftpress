<?php
/*
	Plugin Name: ShiftPress
	Plugin URI: http://www.shiftpress.org
	Description: ShiftSpace for Wordpress!
	Version: 1.0
	Author: C.N
	*/
//Function to add all in WP database to shiftpress DB. 
$dir = dirname(__FILE__);
require_once "$dir/shiftspace/server/ss-call.php";

function batch_add_wp_users_shiftpress(){	

	global $wpdb;

	$all_users = $wpdb->get_results($wpdb->prepare('SELECT user_login, user_pass, user_email FROM wp_users'));

	foreach($all_users as &$users)
	{	
		sscall(Array('method' => 'user.join', 
			'username' => $users->user_login,
			'password' => $users->user_pass,
			'password_again' => $users->user_pass,
			'email' => $users->user_email,
			));			
	}

	sscall(Array ('method'=>'user.logout'));
}	

register_activation_hook( __FILE__, 'batch_add_wp_users_shiftpress');

//Adds users to the shiftpress SQLite page as they are updated by the Wordpress admin.
//password will not be hardcoded in final version.  

add_action('wp_head','shiftpressLoad');	

function shiftpressLoad(){
	echo("\n\n<script type='text/javascript'
		src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/externals/mootools-1.2.3-core.js'></script>\n\n");    	  
	echo("\n\n<script type='text/javascript' src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/externals/mootools-1.2.3.1-more.js'></script>\n\n");
	echo("\n\n<script type='text/javascript' src='".get_bloginfo('wpurl')."/wp-content/plugins/shiftpress/shiftspace/builds/shiftspace.sandbox.js'></script>\n\n");	  
}

//register wordpress user in shiftspace db. 

add_action('user_register','add_user_shiftpress');

function add_user_shiftpress($user_id){

	$user_info = get_userdata($user_id);

	sscall(Array('method' => 'user.join', 
		'username' => $user_info->user_login,
		'password' => '123456',
		'password_again' => '123456',
		'email' => $user_info->user_email,
		));	

	sscall(Array ('method'=>'user.logout'));
}

//Creates new user session. Signs user into shiftpress when they are signed into WordPress.
add_action('wp_login','login_shiftpress');

function login_shiftpress($name){

	$user_info = get_userdatabylogin($name);

	sscall(Array('method' => 'user.login', 
		'username' => $user_info->user_login,
		'password' => '123456',
		));	
}

//Destroys connection to shiftpress when a user logs out of Wordpress.  
add_action('wp_logout','logout_shiftpress');

function logout_shiftpress(){

	sscall(Array('method'=>'user.logout'));

}

//update user profile in shiftpress. 
add_action('profile_update','filter_update_user');

function update_user($user_id){

	$user_info = get_userdata($user_id);

	sscall(Array('method' => 'user.update', 
		'username' => $user_info->user_login,
		'password' => '123456',
		'password_again' => '123456',
		'email' => $user_info->user_email,
		));

	sscall(Array('method'=>'user.logout'));

}

$dir = dirname(__FILE__);
require_once "$dir/admin/shiftpress_admin.php";
?>
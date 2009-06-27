<?php
/*
* Administration menus for shiftpress.
*
*/

// Hook for adding admin menus
add_action('admin_menu', 'ss_add_pages');

// action function for above hook
function ss_add_pages() {
	// Add a new submenu under Options:
	add_options_page('Test Options', 'Test Options', 8, 'testoptions', 'ss_options_page');

	// Add a new submenu under Manage:
	add_management_page('Test Manage', 'Test Manage', 8, 'testmanage', 'ss_manage_page');

	// Add a new top-level menu (ill-advised):
	add_menu_page('shiftpress Menu', 'shiftpress', 8, __FILE__, 'ss_toplevel_page');

	// Add a submenu to the custom top-level menu:
	add_submenu_page(__FILE__, 'Test Sublevel', 'Users Admin', 8, 'sub-page', 'ss_sublevel_page');

	// Add a second submenu to the custom top-level menu:
	add_submenu_page(__FILE__, 'Test Sublevel 2', 'Shifts Admin', 8, 'sub-page2', 'ss_sublevel_page2');
}

function ss_sublevel_page() {
	
	$dir = dirname(__FILE__);
	
	require_once "$dir/shiftspace/server/ss-call.php";
	echo "<h2>SS Users Test</h2>";
	
	$shifts = json_decode(sscall(Array('method' => 'shift.get',
	 			 'shiftIds' => "12, 90",  
				)));
	
	print($shifts);

}
// sp_options_page() displays the page content for the Test Options submenu
function ss_toplevel_page() {

	// variables for the field and option names 
	//$opt_name = 'mt_favorite_food';
	//$hidden_field_name = 'mt_submit_hidden';
	//$data_field_name = 'mt_favorite_food';

	// Read in existing option value from database
	$opt_val = get_option( $opt_name );

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( $_POST[ $hidden_field_name ] == 'Y' ) 
	{
		// Read their posted value
		$opt_val = $_POST[ $data_field_name ];

		// Save the posted value in the database
		update_option( $opt_name, $opt_val );

		// Put an options updated message on the screen

		?>
		<div class="updated"><p><strong><?php _e('Options saved.', 'sp_trans_domain' ); ?></strong></p></div>
	<?php
	}

// Now display the options editing screen

echo '<div class="wrap">';

// header

echo "<h2>" . __( 'Menu Test Plugin Options', 'mt_trans_domain' ) . "</h2>";

// options form

?>

<form name="form1" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

	<p><?php _e("Favorite Color:", 'mt_trans_domain' ); ?> 
		<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
	</p><hr />

	<p class="submit">
		<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
	</p>

</form>
</div>

<?php

}

// ss_manage_page() displays the page content for the Test Manage submenu
function ss_manage_page() {
	echo "<h2>Test Manage</h2>";
}

function ss_sublevel_page2() {
		echo "<h2>Test Shifts Test</h2>";
	}
?>	
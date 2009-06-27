<?php
/*
	* Administration menus for shiftpress.
	*
	*/

// Hook for adding admin menus
add_action('admin_menu', 'sp_add_pages');

// action function for above hook
function sp_add_pages() {
	// Add a new submenu under Options:
	add_options_page('Test Options', 'Test Options', 8, 'testoptions', 'sp_options_page');

	// Add a new submenu under Manage:
	add_management_page('Test Manage', 'Test Manage', 8, 'testmanage', 'sp_manage_page');

	// Add a new top-level menu (ill-advised):
	add_menu_page('shiftpress Menu', 'shiftpress', 8, __FILE__, 'sp_toplevel_page');

	// Add a submenu to the custom top-level menu:
	add_submenu_page(__FILE__, 'Test Sublevel', 'Users Admin', 8, 'sub-page', 'sp_sublevel_page');

	// Add a second submenu to the custom top-level menu:
	add_submenu_page(__FILE__, 'Test Sublevel 2', 'Shifts Admin', 8, 'sub-page2', 'sp_sublevel_page2');
}

function sp_sublevel_page() {

	$dir = dirname(__FILE__);

	require_once "$dir/shiftspace/server/ss-call.php";
	echo "<h2>SS Users Test</h2>";

	$shifts = json_decode(sscall(Array('method' => 'shift.get',
		'shiftIds' => "12, 90",  
		)));
	print($shifts);

}
// sp_options_page() displays the page content for the Test Options submenu
function s_toplevel_page() {
	echo "<h2>Top Level</p>";

}

// sp_manage_page() displays the page content for the Test Manage submenu
function sp_manage_page() {
	echo "<h2>Test Manage</h2>";
}

function sp_sublevel_page2() {
	echo "<h2>Test Shifts Test</h2>";
}
?>	
<?php
/**
 * Plugin Name: Common Login
 * Description: A plugin for Common Login
 */
 
 

add_action('noo_ajax_login', 'modify_login_submit');

function modify_login_submit() {
     $cookie_name = "username";
     $cookie_value = $_REQUEST['log'];
     setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/",".electronicsforu.com"); // 86400 = 1 day
	 return true;

}


 
 
 
 ?>
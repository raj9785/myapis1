<?php

define('SUBDIR', '/');
define('SUBDIR_IMAGE', '/');
define('DBHOST', "localhost");
define('DBUSERNAME', "root");
define('DBPASSWORD', "");
define('DB', "dynamic_ui");
/* * **************************************** End Database details ***************************************** */
/* * **************************************** End Database details ***************************************** */
define('WEBSITE_URL', 'http://localhost/myapis/');
define('WEBSITE_URL_IMAGE', "http://localhost/myapis/");
define('WEBSITE_ADMIN_URL', "http://localhost/myapis/admin/");
define('WEBSITE_JS_URL', WEBSITE_URL . 'js/');
define('WEBSITE_CSS_URL', WEBSITE_URL . 'css/');
define('WEBSITE_IMAGE_URL', WEBSITE_URL . 'img/');
define('WEBSITE_IMG_URL', WEBSITE_URL . 'img/');
define('WEBSITE_IMAGES_URL', WEBSITE_URL . 'images/');
define('WEBSITE_APP_WEBROOT_ROOT_PATH', dirname(__FILE__) . '/app/webroot/');
define('WEBSITE_ADMIN_WEBROOT_ROOT_PATH', dirname(__FILE__) . '/admin/');

define('WEBSITE_COMPANY_WEBROOT_ROOT_PATH', dirname(__FILE__) . '/company');

define('WEBSITE_APP_WEBROOT_IMG_ROOT_PATH', dirname(__FILE__) . '/app/webroot/img/');

define('WBROOT_PATH_LOGO', WEBSITE_ADMIN_WEBROOT_ROOT_PATH . "webroot/uploads/logos/");
define("HTTP_PATH_LOGO", WEBSITE_URL . '/admin/uploads/logos/');

define('WBROOT_PATH_SQLFILES', WEBSITE_ADMIN_WEBROOT_ROOT_PATH . "webroot/uploads/mysql_files/");


define('DEFAULT_DATE_FORMAT', "m/d/Y");
define('SALT', "e7a8e59ba1035768b70e11a6e8cb990fb29694d98ddf207b7525aed6378560aaa68ea41ee17e51aec1fc1594c468e353a6a9e4e4d509a7df8e041ac81744cc91");



/* * **************************************** Include all settings ***************************************** */
require_once('settings.php');

$config['defaultPaginationLimit'] = 10;
/* Admin Configuration */
if (!defined('APP_CACHE_PATH')) {
    define("APP_CACHE_PATH", ROOT . '/app/tmp/cache');
}


if (!defined('SETTING_FILE_PATH')) {
    define("SETTING_FILE_PATH", ROOT . '/settings.php');
}



$config['date_format'] = array('basic' => 'd M, Y h:i a', 'profile' => 'F d, Y');
$config['front_date_format'] = array('basic' => 'M d, Y h:i a', 'profile' => 'd/m/Y');
$config['date_picker_formate'] = 'dd/mm/yy';
$config['Action_options'] = array('Registration' => 'Registration', 'VerificationMail' => 'Verification Email', 'Forgot Password' => 'Forgot Password', 'UserPasswordChangedSuccessfully' => 'Reset Forgot Password', 'campaign_activated' => 'Campaign Activated', 'subscription' => 'Subscription');
$config['registration'] = array('email' => 'EMAIL_ADDRESS', 'website_url' => 'WEBSITE_URL', 'verify_link' => 'VERIFY_LINK');
$config['register_verify'] = array('email' => 'EMAIL_ADDRESS', 'website_url' => 'WEBSITE_URL');
$config['forgot_password'] = array('email' => 'EMAIL_ADDRESS', 'website_url' => 'WEBSITE_URL', 'reset_link' => 'RESET');
$config['reset_forgot_password'] = array('email' => 'EMAIL_ADDRESS', 'website_url' => 'WEBSITE_URL');
$config['campaign_activated'] = array('partner_name' => 'PARTNER_NAME', 'campaign_name' => 'CAMPAIGN_NAME', 'start_date' => 'START_DATE', 'end_date' => 'END_DATE', 'price' => 'PRICE');


define('PDF_HEADER_HTML', '<html><style>
				.Table{clear:both; display:table; width:100%; border-left:1px solid #eee;}
				.Table th, .Table td{border-right:1px solid #eee; border-bottom:1px solid #eee; padding:5px 10px; text-align:left; font:12px Arial, Helvetica, sans-serif; color:#666;}
				.Table th{font:bold 13px Arial, Helvetica, sans-serif; color:#fff; background:#333;}
				.Table td{background:#fdfdfd;}
				.Table tr:hover td{background:#f6f6f6;}
				</style><body><script  type="text/php">$pdf->page_text(550, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, $color);</script><div style="text-align:right;float;right"><img src="' . WEBSITE_APP_WEBROOT_ROOT_PATH . 'img/main-logo.png' . '" ></div><br/><br/><table class="Table" width="100%" colspan="0" cellpadding="0" cellspacing="0" style="border:1px solid #000;"><tr>');

define('PRINT_HEADER_HTML', '<html><style>
				.Table{clear:both; display:table; width:100%; border-left:1px solid #eee;}
				.Table th, .Table td{border-right:1px solid #eee; border-bottom:1px solid #eee; padding:5px 10px; text-align:left; font:12px Arial, Helvetica, sans-serif; color:#666;}
				.Table th{font:bold 13px Arial, Helvetica, sans-serif; color:#fff; background:#333;}
				.Table td{background:#fdfdfd;}
				.Table tr:hover td{background:#f6f6f6;}
				</style><body><img src="' . WEBSITE_APP_WEBROOT_ROOT_PATH . 'img/main-logo.png' . '"><br/><br/>');


define('PDF_FOOTER_HTML', '</br></br>&nbsp;' . Configure::read('Site.Copyright_text'));


define('MAIL_PORT', 25);
define('PAGELIMIT', 1);
define('MAIL_HOST', 'mail.uptostart.com');
define('MAIL_USERNAME', 'aniima@aniima.uptostart.com');
define('MAIL_PASSWORD', 'Champ@123');
define('MAIL_CLIENT', 'gmail.com');

define('URL_DOMAIN', "live");
define("DATETIME_FORMAT", "d-m-y h:i a");

define("COPYWRITE", "All Rights Reserved."); //% amount increase
define('SITETITLE', "Admin Panel"); 
?>

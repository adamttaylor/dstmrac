<?php
#-----------------------------------------
#	RT-Theme functions.php
#	version: 1.0
#-----------------------------------------

# Check PHP Version
if (version_compare(PHP_VERSION, '5.0.0', '<')) {

	$PHP_version_error = '<div id="notice" class="error"><p><strong><h3>THEME ERROR!</h3>This theme requires PHP Version 5 or higher to run. Please upgrade your php version!</strong> <br />You can contact your hosting provider to upgrade PHP version of your website.</p> </div>';
	if(is_admin()){	
		add_action('admin_notices','errorfunction');
	}else{
		echo $PHP_version_error;
		die;
	}
	
	function errorfunction(){
		global $PHP_version_error;
		echo $PHP_version_error;
	}
	
	return false;
}

# Define Content Width
if ( ! isset( $content_width ) ) $content_width = 620;

# Load the theme
require_once (TEMPLATEPATH . '/rt-framework/classes/loading.php');
$rttheme = new RTTheme();
$rttheme->start(array('theme' => 'RT-THEME 15','slug' => 'rttheme','version' => '1.0')); 

if(!current_user_can( 'read' )){
	show_admin_bar(false);
}
/*function redirect_subscriber(){
	echo 'is_user_logged_in() '.is_user_logged_in();
	if ( is_user_logged_in() ){
		if(!current_user_can( 'read' )){
			$url = $_SERVER['REQUEST_URI'];
			$url = str_replace("/",'',$url);
			//When specifying a search url just use the url of the page not including the site address or slashes
			//so http://www.mobileasiaexpo.com/event-terms/ is just event-terms 
			
			if($url == 'wp-admin'){
				wp_redirect( '/', 301 );
				exit;
			}
		}
	}
}*/
function admin_default_page() {
	$url = get_bloginfo('url');
	if(!current_user_can( 'read' ) && strrpos($url,'//http://tagandsword.com/dstmrac')==0){//If on the testsite
		return '/dstmrac/';
	}else if(!current_user_can( 'read' ) ){
		return '/';
	}else{
		return '/wp-admin';
	}
}

add_filter('login_redirect', 'admin_default_page')
?>
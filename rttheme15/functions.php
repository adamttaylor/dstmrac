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
require_once (get_template_directory() . '/rt-framework/classes/loading.php');
$rttheme = new RTTheme();
$rttheme->start(array('theme' => 'RT-THEME 15','slug' => 'rttheme','version' => '1.0')); 

//Adding shortcode functionality to widgets
add_filter('widget_text', 'do_shortcode');

if(!function_exists('member_header')){
	function member_header(){
		return is_user_logged_in()? '' : '<div class="member-title">MEMBER LOGIN</div>';
	}
	add_shortcode( 'member_title', 'member_header' );
}
if(!function_exists('profile_link')){
	function profile_link(){
		//return is_user_logged_in()
		return is_user_logged_in()? '<div class="edit-profile-link"><a href="/edit-profile/">Edit Profile</a></div>' : '';
	}
	add_shortcode( 'edit-profile', 'profile_link' );
}
if(!function_exists('reg_link')){
	function reg_link(){
		return is_user_logged_in()? '' : '<div class="edit-profile-link"><a href="/register/">Memeber Registration</a></div>';
	}
	add_shortcode( 'register', 'reg_link' );
}

//wppb_front_end_login
if(!function_exists('member_form')){
	function member_form(){
		if(is_user_logged_in() && function_exists('wppb_front_end_login')){
			return wppb_front_end_login(false).
			'<div class="edit-profile-link"><a href="/edit-profile/">Edit Profile</a></div>';
		}else if(function_exists('wppb_front_end_login')){
			return '<div class="member-title">MEMBER LOGIN</div>'.
			wppb_front_end_login(false).
			'<div class="edit-profile-link"><a href="/register/">Memeber Registration</a></div>';
		}
	}
	add_shortcode( 'member_login', 'member_form' );
}


add_theme_support( 'post-thumbnails' ); 

if(!function_exists('permalink_untrailingslashit')){
	function permalink_untrailingslashit($link) {
		return untrailingslashit($link);
	}
}
add_filter('page_link', 'permalink_untrailingslashit');
add_filter('post_type_link', 'permalink_untrailingslashit');

if(!function_exists('get_safe_custom')){
	function get_safe_custom($field,$id){
		$custom_fields = get_post_custom($id);
		if($custom_fields){
			if(array_key_exists($field, $custom_fields)){
				$my_custom_field = $custom_fields[$field];
				if($my_custom_field){
					return $custom_fields[$field][0];
				}
			}
		}
		return '';
	}
}

//Page Meta data based on custom fields
if(!function_exists('add_meta_data')){
	function add_meta_data(){
		$title      = get_safe_custom('Meta: Title', get_the_ID());
		$descripton = get_safe_custom('Meta: Description', get_the_ID());
		if($title){
			echo '<meta http-equiv="title" content="'.$title .'">'.PHP_EOL;
		}
		if($descripton){
			echo '<meta http-equiv="description" content="'.$descripton.'">'.PHP_EOL;
		}
		?>
		<!-- AddThis Smart Layers BEGIN -->
        <!-- Go to http://www.addthis.com/get/smart-layers to customize -->
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5321bed95b2361d1"></script>
        <script type="text/javascript">
          addthis.layers({
            'theme' : 'transparent',
            'share' : {
              'position' : 'right',
              'numPreferredServices' : 5
            }, 
            'follow' : {
              'services' : [
                {'service': 'facebook', 'id': 'https://www.facebook.com/dstmrac'},
                {'service': 'twitter', 'id': 'twitter.com/dstmrac'}
              ]
            }   
          });
        </script>
        <!-- AddThis Smart Layers END -->
        <?php
	}
}
add_action('wp_head', 'add_meta_data');

//Redirects
if(!function_exists('all_redirects')){
	function all_redirects(){
		$url = $_SERVER['REQUEST_URI'];
		$url = str_replace("/",'',$url);
		//When specifying a search url just use the url of the page not including the site address or slashes
		//so http://www.mobileasiaexpo.com/event-terms/ is just event-terms 
		$check2 = $url == 'membercalendar' || $url  == 'dstmracmembercalender';
		$check1 = !is_user_logged_in();
		//echo '<p>Found url: '.$url.'__'.$check1.'__'.$check2.'</p>';
		if($url == 'event-calendar'){
			wp_redirect( '/calender/', 302 );
		}
		if($url == 'community'){
			wp_redirect( '/products/', 302 );
		}
		if($url == 'gallery'){
			wp_redirect( '/photo-gallery/', 302 );
		}
		if(($url == 'calender' || $url  == 'dstmraccalender') && is_user_logged_in()){
			wp_redirect( '/member/calender/', 302 );
			exit;
		}
		if(($url == 'membercalendar' || $url  == 'dstmracmembercalender') && !is_user_logged_in()){
			wp_redirect( '/calender/', 302 );
			exit;
		}
		
	}
}
add_action('template_redirect', 'all_redirects');


function my_admin_notification_profile_update($userid) {

    $userdata = get_userdata($userid);
    $message = "A user profile has been updated\n\n";
    $message .= print_r($userdata,true);
    @wp_mail(get_option('admin_email'), 'User Profile Update', $message);

}
add_action('profile_update','my_admin_notification_profile_update');

?>
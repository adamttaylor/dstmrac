<?php
#-----------------------------------------
#	RT-Theme custom_posts.php
#	version: 1.0
#-----------------------------------------

#
# 	Custom Post Types
#

function rt_theme_custom_posts(){
	
	#
	#	Permalink slugs for the custom post types
	#
	
	$portfolio_slug			= get_option(THEMESLUG."_portfolio_single_slug"); 	// singular portfolio item
	$portfolio_categories_slug 	= get_option(THEMESLUG."_portfolio_category_slug"); 	// portfolio categories
	$product_slug 				= get_option(THEMESLUG."_product_single_slug"); 		// singular product item
	$product_categories_slug 	= get_option(THEMESLUG."_product_category_slug");		// product categories 
	
	#
	#	Portfolio
	#
	
	$labels = array(
		'name' 				=> _x('Portfolio', 'portfolio', 'rt_theme_admin'),
		'singular_name' 		=> _x('portfolio', 'portfolio', 'rt_theme_admin'),
		'add_new' 			=> _x('Add New', 'portfolio item', 'rt_theme_admin'),
		'add_new_item' 		=> __('Add New portfolio item', 'rt_theme_admin'),
		'edit_item' 			=> __('Edit Portfolio Item', 'rt_theme_admin'),
		'new_item' 			=> __('New Portfolio Item', 'rt_theme_admin'),
		'view_item' 			=> __('View Portfolio Item', 'rt_theme_admin'),
		'search_items' 		=> __('Search Portfolio Item', 'rt_theme_admin'),
		'not_found' 			=>  __('No portfolio item found', 'rt_theme_admin'),
		'not_found_in_trash' 	=> __('No portfolio item found in Trash', 'rt_theme_admin'), 
		'parent_item_colon' 	=> ''
	);
	
	$args = array(
		'labels' 				=> $labels,
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'exclude_from_search' 	=> false,
		'show_ui' 			=> true, 
		'query_var' 			=> false,
		'can_export' 			=> true,
		'show_in_nav_menus' 	=> true,		
		'capability_type' 		=> 'post',
		'menu_position' 		=> null, 
		'rewrite' 			=> array( 'slug' => $portfolio_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
		'menu_icon' 			=> THEMEADMINURI .'/images/portfolio-icon.png', // 16px16
		'supports' 			=> array('title','editor','author','thumbnail','comments'),
		'capability_type' => 'portfolio',
		'capabilities' => array(
				'read_post' => 'read_portfolio',
				'publish_posts' => 'publish_portfolios',
				'edit_posts' => 'edit_portfolios',
				'edit_others_posts' => 'edit_others_portfolios',
				'delete_posts' => 'delete_portfolios',
				'delete_others_posts' => 'delete_others_portfolios',
				'read_private_posts' => 'read_private_portfolios',
				'edit_post' => 'edit_portfolio',
				'delete_post' => 'delete_portfolio',
	
			)
	);
	function add_portfolio_caps() {
		$role = get_role( 'administrator' );
		
		$role->add_cap( 'edit_portfolio' ); 
		$role->add_cap( 'edit_portfolios' ); 
		$role->add_cap( 'edit_others_portfolios' ); 
		$role->add_cap( 'publish_portfolios' ); 
		$role->add_cap( 'read_portfolio' ); 
		$role->add_cap( 'read_private_portfolios' ); 
		$role->add_cap( 'delete_portfolio' ); 
		
		$role2 = get_role( 'editor' );
		
		$role2->add_cap( 'edit_portfolio' ); 
		$role2->add_cap( 'edit_portfolios' ); 
		$role2->add_cap( 'edit_others_portfolios' ); 
		$role2->add_cap( 'publish_portfolios' ); 
		$role2->add_cap( 'read_portfolio' ); 
		$role2->add_cap( 'read_private_portfolios' ); 
		$role2->add_cap( 'delete_portfolio' ); 
	}
	add_action( 'admin_init', 'add_portfolio_caps');
	
	register_post_type('portfolio',$args);
	
	// Portfolio Categories
	$labels = array(
		'name' 				=> _x( 'Portfolio Categories', 'taxonomy general name' , 'rt_theme_admin'),
		'singular_name' 		=> _x( 'Portfolio Category', 'taxonomy singular name' , 'rt_theme_admin'),
		'search_items' 		=>  __( 'Search Portfolio Category' , 'rt_theme_admin'),
		'all_items' 			=> __( 'All Portfolio Categories' , 'rt_theme_admin'),
		'parent_item'			=> __( 'Parent Portfolio Category' , 'rt_theme_admin'),
		'parent_item_colon' 	=> __( 'Parent Portfolio Category:' , 'rt_theme_admin'),
		'edit_item' 			=> __( 'Edit Portfolio Category' , 'rt_theme_admin'), 
		'update_item' 			=> __( 'Update Portfolio Category' , 'rt_theme_admin'),
		'add_new_item' 		=> __( 'Add New Portfolio Category' , 'rt_theme_admin'),
		'new_item_name' 		=> __( 'New Genre Portfolio Category' , 'rt_theme_admin'),
	); 	
	
	register_taxonomy('portfolio_categories',array('portfolio'), array(
		'hierarchical' 		=> true,
		'labels' 				=> $labels,
		'show_ui' 			=> true,
		'query_var' 			=> false,
		'_builtin' 			=> false,
		'paged'				=>true,
		'rewrite' 			=> array('slug'=>$portfolio_categories_slug,'with_front'=>false),
	));
	
	
	
	
	#
	#	Products
	#
 
	$labels = array(
		'name' 				=> _x('Product', 'product', 'rt_theme_admin'),
		'singular_name' 		=> _x('product', 'product', 'rt_theme_admin'),
		'add_new' 			=> _x('Add New', 'product item', 'rt_theme_admin'),
		'add_new_item' 		=> __('Add New Product Item', 'rt_theme_admin'),
		'edit_item' 			=> __('Edit Product Item', 'rt_theme_admin'),
		'new_item'			=> __('New Product Item', 'rt_theme_admin'),
		'view_item' 			=> __('View Product Item', 'rt_theme_admin'),
		'search_items' 		=> __('Search Product Item', 'rt_theme_admin'),
		'not_found' 			=>  __('No Product Item Iound', 'rt_theme_admin'),
		'not_found_in_trash' 	=> __('No product item found in trash', 'rt_theme_admin'), 
		'parent_item_colon'	 	=> ''
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'show_ui' => true, 
		'query_var' => false,
		'can_export' => true,
		'show_in_nav_menus' => true,		
		'capability_type' => 'post',
		'menu_position' => null, 
		'rewrite' => array( 'slug' => $product_slug, 'with_front' => true, 'pages' => true, 'feeds'=>false ),
		'menu_icon' => THEMEADMINURI .'/images/product-icon.png', // 16px16
		'supports' => array('title','editor','author')
	);
	
	register_post_type('products',$args);
	
	// Product Categories
	$labels = array(
		'name' => _x( 'Product Categories', 'taxonomy general name' , 'rt_theme_admin'),
		'singular_name' => _x( 'Product Category', 'taxonomy singular name' , 'rt_theme_admin'),
		'search_items' =>  __( 'Search Product Category' , 'rt_theme_admin'),
		'all_items' => __( 'All Product Categories' , 'rt_theme_admin'),
		'parent_item' => __( 'Parent Product Category' , 'rt_theme_admin'),
		'parent_item_colon' => __( 'Parent Product Category:' , 'rt_theme_admin'),
		'edit_item' => __( 'Edit Product Category' , 'rt_theme_admin'), 
		'update_item' => __( 'Update Product Category' , 'rt_theme_admin'),
		'add_new_item' => __( 'Add New Product Category' , 'rt_theme_admin'),
		'new_item_name' => __( 'New Genre Product Category' , 'rt_theme_admin'),
	); 	
	
	register_taxonomy('product_categories',array('products'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => false,
		'_builtin' => false,
		'paged'=>true,
		'rewrite' => array('slug'=>$product_categories_slug,'with_front'=>false),
	));



	#
	#	Home Page Slider
	#	
	
	$labels = array(
		'name' => _x('Slider', 'slider', 'rt_theme_admin'),
		'singular_name' => _x('slider', 'slider', 'rt_theme_admin'),
		'add_new' => _x('Add New', 'slider', 'rt_theme_admin'),
		'add_new_item' => __('Add New Slide', 'rt_theme_admin'),
		'edit_item' => __('Edit Slide', 'rt_theme_admin'),
		'new_item' => __('New Slide', 'rt_theme_admin'),
		'view_item' => __('View Slide', 'rt_theme_admin'),
		'search_items' => __('Search Slide', 'rt_theme_admin'),
		'not_found' =>  __('No slide found', 'rt_theme_admin'),
		'not_found_in_trash' => __('No slide found in Trash', 'rt_theme_admin'), 
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true, 
		'capability_type' => 'post', 
		'menu_position' => null,
		'rewrite' => array('slug'=>'slide','with_front'=>false),
		'menu_icon' => THEMEADMINURI .'/images/slides.png', // 16px16
		'supports' => array( 'title', 'thumbnail' )
	); 
	register_post_type('slider',$args);
	
	#
	#	Home Page Contents
	#	
	$labels = array(
		'name' => _x('Home Page', 'home_page', 'rt_theme_admin'),
		'singular_name' => _x('home_page', 'home_page', 'rt_theme_admin'),
		'add_new' => _x('Add New Box', 'home_page', 'rt_theme_admin'),
		'add_new_item' => __('Add New Box', 'rt_theme_admin'),
		'edit_item' => __('Edit Content', 'rt_theme_admin'),
		'new_item' => __('New Content', 'rt_theme_admin'),
		'view_item' => __('View Content', 'rt_theme_admin'),
		'search_items' => __('Search Content', 'rt_theme_admin'),
		'not_found' =>  __('No result found', 'rt_theme_admin'),
		'not_found_in_trash' => __('No result found in Trash', 'rt_theme_admin'), 
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'query_var' => true, 
		'capability_type' => 'post', 
		'menu_position' => null,
		'menu_icon' => THEMEADMINURI .'/images/home_contents.png', // 16px16
		'supports' => array( 'title','editor','author','thumbnail')
	); 
	register_post_type('home_page',$args); 	
	
}

add_action('init','rt_theme_custom_posts',0);
?>
<?php
/* 
* rt-theme archive 
*/
get_header();
$category = get_category_by_slug(get_query_var("category_name"));  
?>

<?php get_template_part( 'sub_page_header', 'sub_page_header_file' );?>

<?php get_template_part( 'loop', 'archive' );?>
 <div class="line large"></div>
        <div class="hp-one">
			<?php if (function_exists('dynamic_sidebar')){ 	dynamic_sidebar('home-page-contents1');	}?>
        </div>
        <div class="hp-two">
			<?php if (function_exists('dynamic_sidebar')){ 	dynamic_sidebar('home-page-contents');	}?>
        </div>
<?php get_footer();?>
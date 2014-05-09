<?php get_header();?>

	<?php get_template_part( 'sub_page_header', 'sub_page_header_file' );?>
		
		
	<!-- slider -->
	<?php if(get_option(THEMESLUG."_slider_active") && is_front_page()){	//if slider active and is front page
			//Slider selection 
			$home_slider_script = get_option(THEMESLUG.'_home_slider_script');

			if($home_slider_script=="" or $home_slider_script=="cycle"){
				get_template_part( 'slider', 'home_slider' );
			}elseif($home_slider_script=="flex"){
				get_template_part( 'flex-slider', 'home_slider' );				
			}else{
				get_template_part( 'nivo-slider', 'home_slider' );
			}
		}
	if ( is_user_logged_in()){?>
        <!-- / slider -->
    
        <!-- page title --> 
        <div class="head_text"><h2><?php the_title(); ?></h2></div><!-- / page title -->  
	
			
		<?php
		
				//featured image	   
				$thumb 			= get_post_thumbnail_id();
				$image_url 		= wp_get_attachment_image_src($thumb,'false', true);
				$width 			= 300;
				$height 			= 300;
				if($thumb) $image 	= @vt_resize( $thumb, '', $width, $height, 'false' );
			?>
	 
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
					<?php if($thumb)://featured image ?>
						<span class="frame alignleft"><a href="<?php echo $image_url[0]; ?>" title="<?php the_title(); ?>" rel="prettyPhoto[page_featured_image]" class="imgeffect plus">
							<img src="<?php echo $image["url"];?>" alt="<?php the_title(); ?>" />
						</a></span>
					<?php endif;?>
									
					<?php the_content(); ?>
					<?php wp_link_pages(); ?>
				<?php endwhile;?>
			
				<?php else: ?>
					<p><?php _e( 'Sorry, no page found.', 'rt_theme'); ?></p>
				<?php endif; ?>
	
			<div class="line large"></div>
			<div class="hp-one">
				<?php if (function_exists('dynamic_sidebar')){ 	dynamic_sidebar('home-page-contents1');	}?>
			</div>
			<div class="hp-two">
				<?php if (function_exists('dynamic_sidebar')){ 	dynamic_sidebar('home-page-contents');	}?>
			</div>
<?php
		}else{
			echo '<h3>You must be a memeber to view this page</h3>';
		}
		get_footer();?>
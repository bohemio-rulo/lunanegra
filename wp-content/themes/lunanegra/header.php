<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>

	<!-- Basic Page Needs
  ================================================== -->
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php bloginfo('name'); ?>  <?php wp_title(); ?></title>

	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<!-- CSS
  ================================================== -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" />
	
	<?php global $gdl_is_responsive ?>
	<?php if( $gdl_is_responsive ){ ?>
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/foundation-responsive.css">
	<?php }else{ ?>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/foundation.css">
	<?php } ?>
	
	<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo GOODLAYERS_PATH; ?>/stylesheet/ie7-style.css" /> 
	<![endif]-->	
	
	<?php
	
		// include favicon in the header
		if(get_option( THEME_SHORT_NAME.'_enable_favicon','disable') == "enable"){
			$gdl_favicon = get_option(THEME_SHORT_NAME.'_favicon_image');
			if( $gdl_favicon ){
				$gdl_favicon = wp_get_attachment_image_src($gdl_favicon, 'full');
				echo '<link rel="shortcut icon" href="' . $gdl_favicon[0] . '" type="image/x-icon" />';
			}
		} 
		
		// add facebook thumbnail to this page
		$thumbnail_id = get_post_thumbnail_id();
		if( !empty($thumbnail_id) ){
			$thumbnail = wp_get_attachment_image_src( $thumbnail_id , '150x150' );
			echo '<link rel="image_src" href="' . $thumbnail[0] . '" />';		
		}
		
		// start calling header script
		wp_head();		

	?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            var width_submenu = 0;
            var count = 0;
            jQuery('#menu-menu-header .sub-menu').children('li').each(function(){
                count++;
                jQuery(this).addClass('width-'+jQuery(this).width());
                width_submenu = width_submenu + jQuery(this).width() + 8;
                
                if(jQuery(this).parent('.sub-menu').children('li').length == count){
                    jQuery(this).parent('.sub-menu').css('width', width_submenu+'px');
                }
            });
            
            jQuery('#menu-menu-header li').hover(function(){
                jQuery(this).next('li').children('a').css('border-left-width', '0');    
            },function(){
                if(!jQuery(this).hasClass('current-menu-item') && !jQuery(this).hasClass('current-menu-parent')){
                    jQuery(this).next('li').children('a').css('border-left-width', '1px');
                } 
            });
            
            jQuery('li.current-menu-item').next('li').children('a').css('border-left-width', '0');
            jQuery('li.current-menu-parent').next('li').children('a').css('border-left-width', '0');
        });
    </script>	
</head>
<body <?php echo body_class(); ?>>
<div class="body-outer-wrapper">
	<div class="body-wrapper boxed-style">
        <div class="header-outer-wrapper">
			<div class="header-wrapper container main">
					
				<!-- Get Logo -->
				<div class="logo-wrapper">
					<?php
						$logo_id = get_option(THEME_SHORT_NAME.'_logo');
						if( empty($logo_id) ){	
							$alt_text = 'default-logo';	
							$logo_attachment = GOODLAYERS_PATH . '/images/default-logo.png';
						}else{
							$alt_text = get_post_meta($logo_id , '_wp_attachment_image_alt', true);	
							$logo_attachment = wp_get_attachment_image_src($logo_id, 'full');
							$logo_attachment = $logo_attachment[0];
						}

						if( is_front_page() ){
							echo '<h1><a href="'; 
							echo home_url();
							echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a></h1>';	
						}else{
							echo '<a href="'; 
							echo home_url();
							echo '"><img src="' . $logo_attachment . '" alt="' . $alt_text . '"/></a>';				
						}
					?>
				</div>
                
                <?php
					// get top navigation left text
					$top_navigation_left_text = do_shortcode( __(get_option(THEME_SHORT_NAME.'_top_navigation_left_text'), 'gdl_front_end') );
					if( !empty($top_navigation_left_text) ){
						echo '<div class="top-navigation-left">' . $top_navigation_left_text . '</div>';
					}		
				?>
				
				<div class="top-navigation-right">
					<!-- Get Social Icons -->
					<div id="gdl-social-icon" class="social-wrapper">
						<div class="social-icon-wrapper">
							<?php
								$gdl_icon_type = get_option(THEME_SHORT_NAME.'_social_network_icon_type','light');;
								$gdl_social_icon = array(
									'delicious'=> array('name'=>THEME_SHORT_NAME.'_delicious', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/delicious.png'),
									'deviantart'=> array('name'=>THEME_SHORT_NAME.'_deviantart', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/deviantart.png'),
									'digg'=> array('name'=>THEME_SHORT_NAME.'_digg', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/digg.png'),
									'facebook' => array('name'=>THEME_SHORT_NAME.'_facebook', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/facebook.png'),
									'flickr' => array('name'=>THEME_SHORT_NAME.'_flickr', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/flickr.png'),
									'lastfm'=> array('name'=>THEME_SHORT_NAME.'_lastfm', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/lastfm.png'),
									'linkedin' => array('name'=>THEME_SHORT_NAME.'_linkedin', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/linkedin.png'),
									'picasa'=> array('name'=>THEME_SHORT_NAME.'_picasa', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/picasa.png'),
									'rss'=> array('name'=>THEME_SHORT_NAME.'_rss', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/rss.png'),
									'stumble-upon'=> array('name'=>THEME_SHORT_NAME.'_stumble_upon', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/stumble-upon.png'),
                                    'twitter' => array('name'=>THEME_SHORT_NAME.'_twitter', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/twitter.png'),
									'tumblr'=> array('name'=>THEME_SHORT_NAME.'_tumblr', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/tumblr.png'),									
									'vimeo' => array('name'=>THEME_SHORT_NAME.'_vimeo', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/vimeo.png'),
									'youtube' => array('name'=>THEME_SHORT_NAME.'_youtube', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/youtube.png'),
									'google_plus' => array('name'=>THEME_SHORT_NAME.'_google_plus', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/google-plus.png'),
									'email' => array('name'=>THEME_SHORT_NAME.'_email', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/email.png'),
									'pinterest' => array('name'=>THEME_SHORT_NAME.'_pinterest', 'url'=> GOODLAYERS_PATH.'/images/icon/' . $gdl_icon_type . '/social-icon/pinterest.png')
								);
								
								foreach( $gdl_social_icon as $social_name => $social_icon ){
									$social_link = get_option($social_icon['name']);
									
									if( !empty($social_link) ){
										echo '<div class="social-icon"><a class="'.$social_name.'" target="_blank" href="' . $social_link . '">' ;
										echo '<img src="' . $social_icon['url'] . '" alt="' . $social_name . '"/>';
										echo '</a></div>';
									}
								}
							?>
						</div> <!-- social icon wrapper -->
					</div> <!-- social wrapper -->
                    
                    <div class="newletter-header">
                        <?php nsu_form(); ?>
                    </div>	

				</div> <!-- top navigation right -->

				<!-- Navigation -->
				<?php 
					// main menu
					echo '<div class="navigation-wrapper">';
					if( has_nav_menu('main_menu') ){
						wp_nav_menu( array('container' => 'div', 'container_class' => 'menu-wrapper', 'container_id' => 'main-superfish-wrapper', 'menu_class'=> 'sf-menu',  'theme_location' => 'main_menu' ) );
					}	
					echo '</div>'; // navigation-wrapper 					
					echo '<div class="clear"></div>';
				
					// responsive menu
					if( $gdl_is_responsive && has_nav_menu('main_menu') ){
						dropdown_menu( array('dropdown_title' => '-- Main Menu --', 'indent_string' => '- ', 'indent_after' => '','container' => 'div', 'container_class' => 'responsive-menu-wrapper', 'theme_location'=>'main_menu') );	
					}
				?>
				
			</div> <!-- header wrapper container -->
		</div> <!-- header outer wrapper -->
		<?php
			if( is_page() ){
				// Top Slider Part
				global $gdl_top_slider_type, $gdl_top_slider_xml;
				if( $gdl_top_slider_type == 'Layer Slider' ){
					$layer_slider_id = get_post_meta( $post->ID, 'page-option-layer-slider-id', true);
					
					echo '<div class="gdl-top-slider-wrapper">';
					echo '<div class="gdl-top-slider-inner-wrapper">';
					echo '<div class="gdl-top-slider">';
					
					echo '<div class="gdl-top-layer-slider">';
					echo do_shortcode('[layerslider id="' . $layer_slider_id . '"]');
					echo '</div>';
					
					echo '<div class="clear"></div>';
					echo '</div>'; // gdl-top-slider
					echo '</div>'; // gdl-top-slider-inner-wrapper
					echo '</div>'; // gdl-top-slider-wrapper
					
				}else if ($gdl_top_slider_type != "No Slider" && $gdl_top_slider_type != ''){
					echo '<div class="gdl-top-slider-wrapper">';
					echo '<div class="gdl-top-slider-inner-wrapper">';
					echo '<div class="gdl-top-slider">';
					
					$slider_xml = "<Slider>" . create_xml_tag('size', 'full-width');
					$slider_xml = $slider_xml . create_xml_tag('height', get_post_meta( $post->ID, 'page-option-top-slider-height', true) );
					$slider_xml = $slider_xml . create_xml_tag('width', 940);
					$slider_xml = $slider_xml . create_xml_tag('slider-type', $gdl_top_slider_type);
					$slider_xml = $slider_xml . $gdl_top_slider_xml;
					$slider_xml = $slider_xml . "</Slider>";
					$slider_xml_dom = new DOMDocument();
					$slider_xml_dom->loadXML($slider_xml);
					print_slider_item($slider_xml_dom->documentElement);
					
					echo '<div class="clear"></div>';
					echo '</div>'; // gdl-top-slider
					echo '</div>'; // gdl-top-slider-inner-wrapper
					echo '</div>'; // gdl-top-slider-wrapper
				}			
				
			}
		?>
        <?php if ( is_home() ):?>
            <div class="slider-home"><?php echo do_shortcode('[layerslider id="1"]'); ?></div>
        <?php endif; ?>
		<div class="content-wrapper container main">
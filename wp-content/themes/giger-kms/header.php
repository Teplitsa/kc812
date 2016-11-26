<?php
/**
 * The header for our theme.
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?> >
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<?php wp_head(); ?>
</head>

<body id="top" <?php body_class(); ?>>
<?php include_once(get_template_directory()."/assets/svg/svg.svg"); //all svgs ?>
<?php do_action('tst_body_start');?>
<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tst' ); ?></a>

<?php if(!is_front_page()) { ?>
<header id="site_header" class="site-header">
	
	
	<div class="container">			
		
			<div class="site-branding">				
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-logo">
					<div id="logo-full" ><?php bloginfo('name')?></div>					
				</a>					
			</div>
			
	</div>
	
</header>
<?php } ?>

<div id="site_content" class="site-content"><a name="#content"></a>
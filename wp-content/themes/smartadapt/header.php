<!DOCTYPE html>
<!--[if lt IE 9]>
<html class="ie lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php

	//display custom header code (Theme Customization)
	echo  smartadapt_option( 'custom_code_header' );

    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
<?php smartadapt_lt_ie7_info(); //display info if IE lower than 7  ?>
<div id="top-bar" class="top-bar home-border">

	<div class="row">
		<div class="columns four mobile-one">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				 title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
				 rel="home"
				 class="site-logo <?php echo ( strlen( smartadapt_option( 'smartadapt_logo' ) ) > 0 ) ? 'image-logo' : ''; ?>">
				<?php
				if ( strlen( smartadapt_option( 'smartadapt_logo' ) ) > 0 ) {
					?>
					<img src="<?php echo smartadapt_option( 'smartadapt_logo' ); ?>"
							 alt="<?php echo bloginfo( 'name' ); ?>" />
					<?php
				}
				else {
					bloginfo( 'name' );
				}
				?></a></div>


		<div class="columns twelve mobile-three">
			<!--falayout search menu-->
			<?php smartadapt_searchmenu(); //display search menu ?>

			<nav id="top-navigation" class="right hide-for-small">
				<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu ' ) ); ?>
			</nav>

		</div>
	</div>
	<div class="row">
		<div class="columns sixteen toggle-area" id="toggle-search">
			<?php smartadapt_searchform(); //display toggle form search  ?>
		</div>
		<div class="columns sixteen toggle-area" id="toggle-menu">
			<nav id="top-navigation-mobile">
				<?php wp_nav_menu( array( 'theme_location' => 'top_pages', 'menu_class' => 'top-menu ' ) ); ?>
			</nav>
		</div>
	</div>
</div>
<div id="wrapper" class="row">
	<div id="page" role="main" class="twelve columns">
		<?php if ( is_front_page() ) :
		smartadapt_header(); //display header info or header image
	else: ?>
		<header class="row" id="breadcrumb">
			<?php  smartadapt_the_bredcrumb(); ?>
		</header>
		<?php
	endif;
		?>
		<div id="main" class="row">
			<div class="four columns">
				<nav id="site-navigation" class="main-navigation hide-for-small" role="navigation">

					<a class="assistive-text" href="#content"
						 title="<?php esc_attr_e( 'Skip to content', 'smartadapt' ); ?>"><?php _e( 'Skip to content', 'smartadapt' ); ?></a>

					<div class="nav-menu tabs vertical">
						<?php wp_nav_menu( array( 'theme_location' => 'categories', 'container' => false ) ); ?>
					</div>
				</nav>
				<nav id="mobile-navigation" class="show-for-small" role="navigation">
					<?php

					//display mobile menu
					smartadapt_wp_nav_menu_select(
						array(
							'theme_location' => 'categories'
						)
					);
					?>

				</nav>
				<!-- #site-navigation -->
			</div>
           




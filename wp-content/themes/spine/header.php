<?php
/**
 * Project Name - Short Description
 *
 * Long Description
 * Can span several lines
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */
?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if IE 8]>
<html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />

	<title><?php hybrid_document_title(); ?></title>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<script src="<?php echo trailingslashit( get_template_directory_uri())  . trailingslashit('js'); ?>modernizr.foundation.js"></script>
	<?php wp_head(); ?>
</head>
<body class="<?php hybrid_body_class(); ?>">

<?php get_template_part( 'menu', 'secondary' ); // Loads the menu-primary.php template. ?>
<header role="banner" class="row">
	<div class="twelve columns">

		<div class="row">
			<div class="seven columns">
				<h1 id="site-title">
					<?php $logo_url = hybrid_get_setting( 'logo_upload' ); if( empty( $logo_url ) ) : ?>
						<a href="<?php echo esc_url( home_url() ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
					<?php else: ?>
					<img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					<?php endif; ?>
				</h1>
			</div><!-- end seven columns -->
			<div class="five columns">
				<h2 id="site-description">
					<small><?php bloginfo( 'description' ); ?></small>
				</h2>
			</div><!-- end five columns -->
		</div><!-- end row -->

		<?php get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. ?>

		<?php if ( get_header_image() ) echo '<img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="" />'; ?>

		<hr />
	</div><!-- end twelve columns -->
</header><!-- End row -->



<!-- Main Page Content and Sidebar -->

<div class="row">
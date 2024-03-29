<?php
/**
 * Template Name: Front Page Template
 *
 * A template for a static front page
 *
 * @package    demos.dev
 * @subpackage subfolder
 * @version    0.1
 * @author     paul <pauldewouters@gmail.com>
 * @copyright  Copyright (c) 2012, Paul de Wouters
 * @link       http://pauldewouters.com
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

get_header(); ?>

<!-- First Band (Image) -->


	<div class="twelve columns">
		<?php dynamic_sidebar('banded-first-band'); ?>
		<hr />
	</div>


<!-- Second Band (Image Left with Text) -->


	<div class="four columns">
		<?php dynamic_sidebar('banded-second-band-1'); ?>
	</div>
	<div class="eight columns">
		<?php dynamic_sidebar('banded-second-band-2'); ?>

	</div>
<hr />


<!-- Third Band (Image Right with Text) -->


	<div class="eight columns">
		<?php dynamic_sidebar('banded-third-band-1'); ?>
	</div>
	<div class="four columns">
		<?php dynamic_sidebar('banded-third-band-2'); ?>
	</div>


<?php get_footer();
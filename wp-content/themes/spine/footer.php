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
get_sidebar( 'primary' );
?>
</div>

<!-- End Main Content and Sidebar -->

<!-- Subsidiary widget area -->


		<?php get_sidebar('subsidiary'); ?>


<!-- Footer -->

<footer class="row" role="contentinfo">
	<div class="twelve columns">
		<hr />
		<div class="row">
			<div class="six columns">
				<?php hybrid_footer_content(); ?>
			</div>
			<div class="six columns">
				<?php get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template. ?>
			</div>
		</div>
	</div>
</footer>

<!-- End Footer -->

<?php wp_footer(); ?>
</body>
</html>
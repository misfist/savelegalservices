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
		<div class="search">

				<form method="get" class="search-form"  role="search" action="<?php echo trailingslashit( home_url() ); ?>">
						<div class="row collapse">
				<div class="eight mobile-three columns">
					<input class="search-text" type="text" name="s" value="<?php if ( is_search() ) echo esc_attr( get_search_query() ); else esc_attr_e( 'Enter search terms...', 'spine' ); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" />
					</div>
					<div class="four mobile-one columns">
              <input type="submit" href="#" class="postfix small button expand" value="<?php _e('Search', 'spine'); ?>">
				</div>
            </div>
				</form><!-- .search-form -->

			</div><!-- .search -->
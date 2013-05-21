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

class NavBar_Walker extends Walker_Nav_Menu{
	var $flyout_dir;

	function __construct($flyout_dir) {

		$this->flyout_dir = $flyout_dir;
	}

// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<a href=\"#\" class=\"flyout-toggle\"><span> </span></a><ul class=\"flyout $this->flyout_dir\">\n";
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		if($depth == 0)
			$output .= "</li>\n<li class=\"divider\"></li>\n";
		else
			$output .= "</li>\n";
	}

	function display_element($element, &$children_elements, $max_depth, $depth=0, $args, &$output) {
		$id_field = $this->db_fields['id'];
		if (!empty($children_elements[$element->$id_field])) {
			$element->classes[] = 'has-flyout'; //enter any classname you like here!
		}
		Walker_Nav_Menu::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
	}
}
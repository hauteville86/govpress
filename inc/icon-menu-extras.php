<?php

/**
 * Removes any custom icon class applied to a menu item.
 *
 * @param array $classes Classes applied to menu item.
 * @return array
 */
function govpress_menu_css_class( $classes ) {

	foreach( $classes as $key => $val ) {
		if ( 'icon' == substr( $val, 0, 4 ) ) {
			unset( $classes[$key] );
		}
	}
	return $classes;
}

add_filter( 'nav_menu_css_class', 'govpress_menu_css_class' );

/**
 * Filter the HTML attributes applied to a menu item's <a>.
 * If a custom icon class was applied to a menu item, it will
 * be placed on the a link rather than the li.
 *
 * @param array $atts {
 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
 *
 *     @type string $title  The title attribute.
 *     @type string $target The target attribute.
 *     @type string $rel    The rel attribute.
 *     @type string $href   The href attribute.
 * }
 * @param object $item The current menu item.
 * @param array  $args An array of arguments. @see wp_nav_menu()
 */
function govpress_nav_menu_link_attributes( $atts, $item, $args ) {

	$class = 'icon-info-circle';
	if ( $item->classes ) {
		foreach( $item->classes as $key => $val ) {
			if ( 'icon' == substr( $val, 0, 4 ) ) {
				$class = $val;
			}
		}
	}
	if ( $class ) {
		$atts['class'] = $class;
	}
	return $atts;

}

add_filter( 'nav_menu_link_attributes', 'govpress_nav_menu_link_attributes', 3, 10 );
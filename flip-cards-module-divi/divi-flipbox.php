<?php
/*
Plugin Name: Flip Cards Module For Divi
Plugin URI:  http://www.learnhowwp.com/divi-flipbox-plugin
Description: This plugin adds a Flipbox Modules in the Divi Builder which allows you to create flip cards on your website easily.
Version:     0.9.4.2
Author:      learnhowwp.com
Author URI:  http://www.learnhowwp.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: lwp-divi-flipbox
Domain Path: /languages

Divi Flipbox is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Divi Flipbox is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Divi Flipbox. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/


if ( ! function_exists( 'lwp_flipbox_initialize_extension' ) ) :
	/**
	 * Creates the extension's main class instance.
	 *
	 * @since 1.0.0
	 */
	function lwp_flipbox_initialize_extension() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/DiviFlipbox.php';
	}
	add_action( 'divi_extensions_init', 'lwp_flipbox_initialize_extension' );
endif;

// ======================================================================================

if ( ! function_exists( 'lwp_flip_cards_add_action_links' ) ) :

	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'lwp_flip_cards_add_action_links' );

	/**
	 * Adds custom action links to the plugin page.
	 *
	 * This function adds a "Rate Plugin" link to the action links on the plugin page.
	 *
	 * @param array $actions Existing action links.
	 * @return array Modified action links.
	 */
	function lwp_flip_cards_add_action_links( $actions ) {
		$mylinks = array(
			'<a href="https://wordpress.org/support/plugin/flip-cards-module-divi/reviews/?filter=5" target="_blank">' . esc_html__( 'Rate Plugin', 'lwp-divi-flipbox' ) . '</a>',
		);
		$actions = array_merge( $actions, $mylinks );
		return $actions;
	}

endif;

if ( ! function_exists( 'lwp_flip_cards_plugin_row_meta' ) ) :

	add_filter( 'plugin_row_meta', 'lwp_flip_cards_plugin_row_meta', 10, 2 );

	/**
	 * Adds custom meta links to the plugin page.
	 *
	 * This function adds "Getting Started Guide" and "More Divi Plugins" links to the meta links on the plugin page.
	 *
	 * @param array  $links Existing meta links.
	 * @param string $file  The filename of the plugin.
	 * @return array Modified meta links.
	 */
	function lwp_flip_cards_plugin_row_meta( $links, $file ) {

		if ( plugin_basename( __FILE__ ) === $file ) {
			$new_links = array(
				'<a href="https://www.learnhowwp.com/add-flip-cards-divi/" target="_blank">' . esc_html__( 'Getting Started Guide', 'lwp-divi-flipbox' ) . '</a>',
				'<a href="https://www.learnhowwp.com/divi-plugins/" target="_blank">' . esc_html__( 'More Divi Plugins', 'lwp-divi-flipbox' ) . '</a>',
			);

			$links = array_merge( $links, $new_links );
		}

		return $links;
	}

endif;

// ======================================================================================

if ( ! function_exists( 'lwp_flip_cards_add_icons' ) ) :

	add_filter( 'et_global_assets_list', 'lwp_flip_cards_add_icons', 10 );

	/**
	 * Adds Divi icons to the global assets list.
	 *
	 * This function checks if the 'et_icons_all' and 'et_icons_fa' assets are set.
	 * If they are not, it adds them to the assets list with their respective CSS paths.
	 *
	 * @param array $assets The existing global assets list.
	 * @return array The modified global assets list.
	 */
	function lwp_flip_cards_add_icons( $assets ) {
		if ( isset( $assets['et_icons_all'] ) && isset( $assets['et_icons_fa'] ) ) {
			return $assets;
		}

		$assets_prefix = et_get_dynamic_assets_path();

		$assets['et_icons_all'] = array(
			'css' => "{$assets_prefix}/css/icons_all.css",
		);

		$assets['et_icons_fa'] = array(
			'css' => "{$assets_prefix}/css/icons_fa_all.css",
		);

		return $assets;
	}

endif;

// ======================================================================================

if ( ! class_exists( 'LWP_CARDS_RATING' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-lwp-cards-rating.php';
	$lwp_cards_rating = new LWP_CARDS_RATING();
	register_activation_hook( __FILE__, array( $lwp_cards_rating, 'flip_cards_activation_time' ) );
}

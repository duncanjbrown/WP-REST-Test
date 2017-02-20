<?php
/**
 * Plugin Name: Rest-testing
 * Version: 0.1-alpha
 * Description: PLUGIN DESCRIPTION HERE
 * Author: YOUR NAME HERE
 * Author URI: YOUR SITE HERE
 * Plugin URI: PLUGIN SITE HERE
 * Text Domain: rest-testing
 * Domain Path: /languages
 * @package Rest-testing
 */
add_filter( 'allowed_redirect_hosts' , 'my_allowed_redirect_hosts' , 10 );
function my_allowed_redirect_hosts($content){
    $content[] = 'localhost:3030';
    return $content;
}
add_action('init', function() {
	register_post_type(
		'custom_post_type',
		[
			'labels' => [
				'name' => 'Custom Post Type',
				'menu_name' => 'Custom'
			],
			'public' => true,
			'show_in_rest' => true
		]
	);
	register_taxonomy( 'custom_taxonomy', array( 'custom_post_type', 'post' ), array(
		'hierarchical'      => false,
		'public'            => true,
		'show_in_rest' => true,
		'labels'            => array(
			'name'                       => 'Custom taxonomy',
			'singular_name'              => 'Custom taxonomy',
			'menu_name'                  => 'Custom taxonomy'
		),
	) );
});

// Enable postmeta embedding for WP-API v > 2.0b12

add_action( 'rest_api_init', function() {

	$post_types = get_post_types( array( 'public' => true ), 'names' );

	foreach( $post_types as $post_type ) {
		if ( post_type_supports( $post_type, 'custom-fields' ) ) {
			add_filter( "rest_prepare_${post_type}", 'prepare_meta_link_for_post_type' , 10, 3);
		}
	}

	function prepare_meta_link_for_post_type( $response, $post, $request ) {
		$post_type = get_post_type_object( $post->post_type );
		$rest_base = ! empty( $post_type->rest_base ) ? $post_type->rest_base : $post_type->name;
		$base = sprintf( '/wp/v2/%s/', $rest_base );
		$response->add_link(
			'https://api.w.org/meta',
			rest_url( $base . $post->ID . '/meta' ),
			array( 'embeddable' => true )
		);
		return $response;
	}
});

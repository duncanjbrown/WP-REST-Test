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

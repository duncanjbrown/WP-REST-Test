<?php

/**
 * Get the details out of the output of wp oauth1 add
 */
$credentials = file_get_contents('oauth_credentials');
$split = explode( "\n", $credentials );

$id = explode( ": ", $split[0] );
$id = end( $id );
$key = explode( ": ", $split[1] );
$consumer_key = end( $key );
$secret = explode( ": ", $split[2] );
$consumer_secret = end( $secret );

$options = compact( 'consumer_key', 'consumer_secret' );

unlink('oauth_credentials');

/**
 * Save them for later
 */
file_put_contents( 'oauth-submitter/consumer.json', json_encode( $options ) );

/**
 * Update the oAuth account credentials with our local callback
 */
update_post_meta( $id, 'callback', 'http://localhost:3030/callback.php' );

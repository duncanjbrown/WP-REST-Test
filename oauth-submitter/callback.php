<?php

require_once 'vendor/autoload.php';

session_start();

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

$token = $_GET['oauth_token'];
$oauth_verifier = $_GET['oauth_verifier'];

$stack = HandlerStack::create();

$consumer_credentials = json_decode( file_get_contents( 'consumer.json' ), true );

$middleware = new Oauth1( array_merge( $consumer_credentials, [
	'token' => $_SESSION['oauth_token'],
	'token_secret' => $_SESSION['oauth_token_secret']
] ) );

$stack->push($middleware);

$client = new Client([
	'base_uri' => 'http://localhost:8080/',
	'handler' => $stack,
	'auth' => 'oauth'
]);

try {
	$req = $client->post('oauth1/access', ['form_params' => [ 'oauth_verifier' => $oauth_verifier ] ]);
    $params = (string)$req->getBody();

    parse_str($params);

	$credentials = [
		'consumer_key' => 'ONptPZtywAbn',
	    'consumer_secret' => 'MvuODbEx6Fyhwb0eBF5t9fulrcwDuCSJUDE8FmYfkNxyMf3k',
		'oauth_token' => $oauth_token,
		'oauth_token_secret' => $oauth_token_secret
	];

	file_put_contents( 'access.json', json_encode( $credentials ) );

	echo '<h2>All done!</h2> <p>Credentials below, also saved to oauth-submitter/access.json.</p>';

	echo '<pre>'.json_encode( $credentials ).'</pre>';

} catch (ClientException $e) {
    dump((string)$e->getResponse()->getBody());
} catch (\Exception $e) {
    dump($e);
}

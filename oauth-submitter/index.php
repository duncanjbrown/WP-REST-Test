<?php

require_once 'vendor/autoload.php';

session_start();

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

$stack = HandlerStack::create();

$consumer_credentials = json_decode( file_get_contents( 'consumer.json' ), true );

$middleware = new Oauth1($consumer_credentials);

$stack->push($middleware);

$client = new Client([
	'base_uri' => 'http://localhost:8080/',
	'handler' => $stack,
	'auth' => 'oauth'
]);

$callback = 'http://localhost:3030/callback.php';

$res = $client->post('http://localhost:8080/oauth1/request', [ 'form_params' => ['oauth_callback' => $callback]]);

try {

    parse_str($res->getBody());

    $_SESSION['oauth_token'] = $oauth_token;
    $_SESSION['oauth_token_secret'] = $oauth_token_secret;

    header("Location: http://localhost:8080/oauth1/authorize?oauth_token={$oauth_token}&oauth_token_secret={$oauth_token_secret}");

} catch (\Exception $e) {
    dump($e);
}

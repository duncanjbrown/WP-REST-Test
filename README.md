# Bare WP config for testing a REST API client

(Boilerplate site based on [roots/bedrock](https://github.com/roots/bedrock))

Download, then configure `.env` from `.env.example`. (Set the site URL to `http://localhost:8080` **with no trailing slash**).

Run `composer install`.

Fill the database/reset everything by running

```
scripts/initialize.sh
```

Set up some OAuth credentials by running

```
scripts/oauth.sh
```

Start the API server with
```
wp server
```

You'll find the API at `http://localhost:8080/wp-json/wp/v2`.

Enjoy!

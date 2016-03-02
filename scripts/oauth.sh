#!/usr/bin/env bash
wp server
pkill -f "php -S localhost:3030"
echo
echo "=> Creating Oauth account..."
wp oauth1 add > oauth_credentials
wp eval-file "scripts/oauth.php"
echo
echo "=> Authorize the account. Open http://localhost:3030 in your web browser and click 'Authorize'"
echo "(The username and password are both 'admin')"
echo
cd oauth-submitter
open http://localhost:3030 # os x only so far, sorry
echo
echo "Hit Ctrl-C to finish"
php -S localhost:3030 > /dev/null 2>&1

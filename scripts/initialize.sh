#!/usr/bin/env bash

read -p "This will wipe your database. Are you sure you want to continue? " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
  wp db reset --yes
  wp core install --url="http://localhost:8080" --title="WP REST Test" --admin_user="admin" --admin_password="admin" --admin_email="null@void.com"
  wp plugin activate json-rest-api json-rest-api-meta-endpoints oauth1
	wp rewrite structure "/%post%/"
  wp post generate --post_type="post"
  wp post generate --post_type="custom_post_type"
  wp media import 'image.png'

  # Add every tenth post to the first term
  for i in $(seq 10 10 200);
    do wp post term add $i custom_taxonomy 'term_one';
  done

  # Add every twentieth post to the second term
  for i in $(seq 10 20 200);
    do wp post term add $i custom_taxonomy 'term_two';
  done

  # Make post number 1 have everything
  wp post meta add 1 _thumbnail_id 203 # this is the id of the featured image
  wp post meta add 1 example_metadata_field 'example_meta_value'
  wp post meta add 1 example_associated_post_id 100
fi

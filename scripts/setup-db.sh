#!/bin/bash

# This script is used to setup the database for the first time if database does not exist
# It will ask you if you want to run migrations and load fixtures
# It will also ask you if you want to make a dump of the database

DIR="$(cd "$(dirname "$0")" && pwd)"

echo "Deleting old symfony cache files ..."

if [ -d "$DIR/var/cache" ]; then \
  rm -rf "$DIR/var/cache" \
;fi

echo "Setting up database ..."

# if already exists, there can be located some data, so we need to drop it with --force
$DIR/../bin/console doctrine:database:drop --if-exists --force
$DIR/../bin/console doctrine:database:create
$DIR/../bin/console doctrine:schema:create

chmod -R 777 var/cache

echo
echo "All done! 😎. Enjoy!"
exit 0
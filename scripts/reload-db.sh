#!/bin/bash

DIR="$(cd "$(dirname "$0")" && pwd)"

echo "Realoading database ..."

if [ -d "$DIR/var/cache" ]; then \
  rm -rf "$DIR/var/cache" \
;fi

$DIR/../bin/console doctrine:database:drop --if-exists --force
$DIR/../bin/console doctrine:database:create
$DIR/../bin/console doctrine:migrations:migrate --no-interaction
$DIR/../bin/console doctrine:schema:validate

if [ $? -eq 0 ]; then \
  echo "Found no changes with migrations. No action is required" \
;else \
  echo "Creating new migration ..." \
  $DIR/../bin/console make:migration \

  echo "All done, please modify and commit new migration file" \
  sleep 2 \
  clear \
;fi

echo "Should I load fixtures? (y/N)"
read -r answer

if [ -z "$answer" ]; then
    answer="n"
    exit 0 \
fi

if [ "$answer" != "${answer#[Yy]}" ] ;then
    $DIR/../bin/console doctrine:fixtures:load --no-interaction
fi

echo
echo "All done! 😎. Enjoy!"
exit 0
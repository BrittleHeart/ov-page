<!-- Docker images readme -->
# Instroduction
Welcome to my ```php``` repository. This repository contains a ```Dockerfile``` to build a [Docker](https://www.docker.com/) container image for [PHP](http://php.net/).

## heraxles/php:<```version```>-symfony
This image is based on the official [php](https://registry.hub.docker.com/_/php/) image and contains the [Symfony](http://symfony.com/) framework, that allows you to create powerful web applications and APIs 
with symfony console, composer and xdebug.

## heraxles/php:<```version```>-pure
This image is based on the official [php](https://registry.hub.docker.com/_/php/) image and contains only the php interpreter and base php extensions with composer installed only.

# Usage
If you want to, you can easily create a ```docker-compose.yml``` file, with the following content:
```yaml
version: '3'

services:
  php:
    image: heraxles/php:<```version```>-symfony
    volumes:
      - .:/var/www/html
      # some other volumes
    ports:
      - ...
  nginx:
    image: nginx
    volumes:
      - .:/var/www/html
      # some other volumes
    ports:
      - ...
    depends_on:
      - php
```
Then you can run ```docker-compose up -d``` and you will have a php container running.

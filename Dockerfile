FROM php:8.1-fpm-alpine

WORKDIR /var/www

# Update packages
RUN apk update

# Install packages
RUN apk add \
  make \
  g++ \
  autoconf \
  libtool \
  libpng-dev \
  libjpeg-turbo-dev \
  libzip-dev \
  libxml2-dev \
  libxml2-utils \
  ncurses-dev \
  build-base \
  bash \
  git \
  curl \
  wget \
  unzip \
  zip \
  postgresql-dev \
  imagemagick-dev \
  freetype-dev \
  icu-dev \
  oniguruma-dev \
  zsh \
  vim \
  postgresql-client

# Install PHP extensions
RUN docker-php-ext-install gd -j$(nproc) \
  pdo_pgsql \
  pgsql \
  bcmath \
  opcache \
  mbstring \
  exif \
  intl

RUN docker-php-ext-configure zip
RUN docker-php-ext-configure gd --with-jpeg --with-freetype

ARG INSTALL_SYMFONY
ARG INSTALL_XDEBUG

# if env INSTALL_SYMFONY is true, install symfony cli
RUN if $INSTALL_SYMFONY = true; then \
  echo "Installing symfony cli" && \
  wget https://get.symfony.com/cli/installer -O - | bash && \
  mv /root/.symfony5/bin/symfony /usr/local/bin/symfony && \
  echo "alias sf='symfony'" >> /root/.bashrc \
;fi

# if env INSTALL_XDEBUG is true, install xdebug
RUN if $INSTALL_XDEBUG = true; then \
  echo "Installing xdebug" && \
  apk add --no-cache linux-headers && \
  pecl install xdebug && \
  docker-php-ext-enable xdebug \
;fi

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]

EXPOSE 9000
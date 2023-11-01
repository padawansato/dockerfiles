FROM php:8.2-fpm

# llコマンド登録
RUN echo -e "\n\
alias ll='ls -la --color'\n\
" >> /root/.bashrc

# timezone
RUN apt-get update -y \
    && apt-get install -y \
    locales \
    locales-all \
    && apt-get clean \
    && ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

RUN locale-gen ja_JP.UTF-8
ENV LANG ja_JP.UTF-8
ENV LC_CTYPE ja_JP.UTF-8
RUN localedef -f UTF-8 -i ja_JP ja_JP.utf8

RUN set -x \
    && apt-get update -y \
    && apt-get install -y \
    autoconf \
    git \
    less \
    libbz2-dev \
    libc-dev \
    libcurl4-openssl-dev \
    libssh2-1-dev \
    libssh2-1 \
    libssl-dev \
    libxslt-dev \
    pkg-config \
    procps \
    unzip \
    wget \
    xz-utils \
    zlib1g-dev \
    && apt-get clean

# composer
RUN set -x \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# PDO
RUN docker-php-ext-install pdo_mysql

# Xdebug
RUN set -x \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

# php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
COPY php.ini /usr/local/etc/php/conf.d/php.ini

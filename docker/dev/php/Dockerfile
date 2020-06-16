FROM php:7.4.7-fpm-alpine3.12

ENV USER_NAME=devuser
ENV HOME=/home/$USER_NAME
ENV COMPOSER_HOME=$HOME/.composer
ENV PATH ./vendor/bin:$COMPOSER_HOME/vendor/bin:$PATH

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    zip \
    unzip

RUN docker-php-ext-install opcache pdo_mysql
RUN docker-php-ext-enable opcache

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/cache/apk/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY php.ini /usr/local/etc/php/conf.d/php.override.ini
COPY www.conf /usr/local/etc/php-fpm.d/www.conf

# Create system user to run Composer and Artisan Commands
RUN adduser --disabled-password --gecos "" ${USER_NAME} \
    && echo "${USER_NAME}  ALL = ( ALL ) NOPASSWD: ALL" >> /etc/sudoers \
    && mkdir -p /var/www/html \
    && mkdir -p $COMPOSER_HOME \
    && chown -R ${USER_NAME}:${USER_NAME} /var/www $HOME \
    && chown -R ${USER_NAME}:${USER_NAME} $COMPOSER_HOME

USER $USER_NAME
WORKDIR /app

CMD ["php-fpm", "--nodaemonize"]
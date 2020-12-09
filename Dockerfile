FROM php:7.1-alpine

RUN apk add --no-cache make && \
	docker-php-ext-enable opcache

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -s https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php -- --quiet && \
        mv composer.phar /usr/local/bin/composer

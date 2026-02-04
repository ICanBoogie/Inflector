ARG PHP_TAG=7.4-cli-bullseye
FROM php:${PHP_TAG}

RUN <<-EOF
	apt-get update
	apt-get install unzip
	docker-php-ext-enable opcache
EOF

RUN <<-EOF
	cat <<-SHELL >> /usr/local/etc/php/conf.d/php.ini
	display_errors=On
	error_reporting=E_ALL
	date.timezone=UTC
	SHELL
EOF

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV PATH="/root/.composer/vendor/bin:${PATH}"

RUN composer global require squizlabs/php_codesniffer

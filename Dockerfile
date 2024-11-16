ARG PHP_TAG=7.1-cli-buster
FROM php:${PHP_TAG}

RUN <<-EOF
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

RUN <<-EOF
	apt-get update
	apt-get install unzip
	curl -s https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer | php -- --quiet
	mv composer.phar /usr/local/bin/composer
	cat <<-SHELL >> /root/.bashrc
	export PATH="$HOME/.composer/vendor/bin:$PATH"
	SHELL
EOF

RUN composer global require squizlabs/php_codesniffer

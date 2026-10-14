ARG PHP_TAG=7.4-cli-bullseye
FROM php:${PHP_TAG}

# Debian 11 (bullseye) is archived, the 7.4 image needs the archive mirror.
RUN <<-EOF
	set -e
	if [ -f /etc/apt/sources.list ]; then
		sed -i 's#deb.debian.org#archive.debian.org#; s#security.debian.org#archive.debian.org#' /etc/apt/sources.list
	fi
	apt-get update
	apt-get install -y unzip
EOF

RUN <<-EOF
	cat <<-SHELL >> /usr/local/etc/php/conf.d/php.ini
	display_errors=On
	error_reporting=E_ALL
	date.timezone=UTC
	SHELL
EOF

# composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# lint

RUN composer global require friendsofphp/php-cs-fixer

# customization

PACKAGE_NAME = icanboogie/inflector
PACKAGE_VERSION = 2.0
PHPUNIT = vendor/bin/phpunit

# do not edit the following lines

usage:
	@echo "test:  Runs the test suite.\ndoc:   Creates the documentation.\nclean: Removes the documentation, the dependencies and the Composer files."

vendor:
	@COMPOSER_ROOT_VERSION=$(PACKAGE_VERSION) composer install

update:
	@COMPOSER_ROOT_VERSION=$(PACKAGE_VERSION) composer update

test: vendor
	@$(PHPUNIT)

test-coverage: vendor
	@mkdir -p build/coverage
	@$(PHPUNIT) --coverage-html build/coverage

test-coveralls: vendor
	@mkdir -p build/logs
	@$(PHPUNIT) --coverage-clover build/logs/clover.xml

test-container:
	@docker-compose run --rm tests sh
	@docker-compose down

doc: vendor
	@mkdir -p build/docs
	@apigen generate \
	--source lib \
	--destination build/docs/ \
	--title "$(PACKAGE_NAME) v$(PACKAGE_VERSION)" \
	--template-theme "bootstrap"

clean:
	@rm -fR build
	@rm -fR vendor
	@rm -f composer.lock

.PHONY: all autoload doc clean test test-coverage test-dependencies test-coveralls update

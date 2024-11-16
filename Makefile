# customization

PHPUNIT = vendor/bin/phpunit --configuration=phpunit$(PHPUNIT_VERSION).xml

# do not edit the following lines

vendor:
	@composer install

.PHONY: test-dependencies
test-dependencies: vendor

.PHONY: test
test: test-dependencies
	@XDEBUG_MODE=none $(PHPUNIT)

.PHONY: test-coverage
test-coverage: test-dependencies
	@mkdir -p build/coverage
	@XDEBUG_MODE=coverage $(PHPUNIT) --coverage-html build/coverage

.PHONY: test-coveralls
test-coveralls: test-dependencies
	@mkdir -p build/logs
	@XDEBUG_MODE=coverage $(PHPUNIT) --coverage-clover build/logs/clover.xml

.PHONY: test-container
test-container: test-container-71

.PHONY: test-container-71
test-container-71:
	@-docker-compose run --rm app71 bash
	@docker-compose down -v

.PHONY: test-container-84
test-container-84:
	@-docker-compose run --rm app84 bash
	@docker-compose down -v

.PHONY: lint
lint:
	@XDEBUG_MODE=off phpcs -s
	@XDEBUG_MODE=off vendor/bin/phpstan

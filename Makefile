DIR := ${CURDIR}

test-php82:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.2 make test

test-php83:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.3 make test

test-php84:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.4 make test

test:
	composer update --prefer-dist --no-interaction ${COMPOSER_PARAMS}
	composer test

test-lowest:
	COMPOSER_PARAMS='--prefer-lowest' make test

test-php82-lowest:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.2 make test-lowest

test-php83-lowest:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.3 make test-lowest

test-php84-lowest:
	docker run --rm -v $(DIR):/project -w /project webdevops/php:8.4 make test-lowest

cs: composer.lock
	docker run --rm -v $(DIR):/project -w /project jakzal/phpqa:php8.5 php-cs-fixer fix -vv ${CS_PARAMS}

test-cs: composer.lock
	CS_PARAMS='--dry-run' make cs

static: composer.lock
	docker run --rm -v $(DIR):/project -w /project jakzal/phpqa phpstan analyze -c .phpstan.neon

composer.lock:
	docker run --rm -v $(DIR):/project -w /project jakzal/phpqa composer install

.PHONY: start
start: composer .docker-compose-up
	@docker-compose up -d

.PHONY: .docker-compose-up
.docker-compose-up:
	@docker-compose up -d

.PHONY: stop
stop:
	@docker-compose stop

.PHONY: composer
composer:
	@docker run --rm -ti --volume ${PWD}:/app --user $(id -u):$(id -g) \
		composer:2 install \
			--ignore-platform-reqs \
			--no-ansi

.PHONY: reset-db
reset-db:
	@docker-compose exec php bin/console doctrine:schema:drop --force
	@docker-compose exec php bin/console doctrine:schema:update --force
	@docker-compose exec php bin/console cache:clear

.PHONY: tests
tests: reset-db
	@docker-compose exec php ./bin/phpunit
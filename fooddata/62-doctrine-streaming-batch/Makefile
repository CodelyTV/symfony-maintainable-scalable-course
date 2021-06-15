.PHONY: start
start:
	@docker-compose up -d

reset:
	@docker-compose exec php bin/console cache:clear
	@docker-compose exec php bin/console doctrine:schema:drop --force
	@docker-compose exec php bin/console doctrine:schema:update --force

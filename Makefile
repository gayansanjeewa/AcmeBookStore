PHP_SERVICE := app
USERID=$(shell id -u)
GROUPID=$(shell id -g)

help: ## Shows all available commands with their description

	$(info Available Commands:)
	@cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

ps: ## List containers

	@docker-compose ps

build: ## Builds the docker images and executes the vendors

	@docker-compose build
	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) composer install

up: ## Builds, (re)creates, starts, and attaches to containers for a service

	@docker-compose up -d
	@make -s ps

composer: ## Allow to use the composer command. Usage: make composer c='require symfony/assets'
	@docker-compose exec -T $(PHP_SERVICE) composer install

database:
	@docker-compose exec -T $(PHP_SERVICE) bin/console doctrine:schema:update

test:
	@docker-compose exec -T $(PHP_SERVICE) vendor/bin/php-cs-fixer fix src --rules=@PSR2 --using-cache=no --dry-run --verbose --diff
	@docker-compose exec -T $(PHP_SERVICE) bin/console security:check

down:
	@docker-compose down

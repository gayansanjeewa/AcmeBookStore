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

composer: ## Allow to use the composer commands. Usage: make composer i='require symfony/assets'
	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) composer $(i)

test: ## Run test
	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) php ./bin/phpunit $(i)

down:
	@docker-compose down

fix-cs: ## Runs the code style fixer

	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) ./vendor/bin/php-cs-fixer fix -v --config=.php_cs.dist --show-progress=dots --allow-risky=yes

check-cs: ## Dry-run the code style fixer and provide diff if available

	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) ./vendor/bin/php-cs-fixer fix --dry-run -v --config=.php_cs.dist --show-progress=dots --allow-risky=yes

sh: ## Gets inside a container, use 'i' variable to select a service. Usage: make sh i=app

	@docker-compose run --rm -u $(USERID):$(GROUPID) sh -l $(i)

app: ## Gets inside app container, use 'i' variable to select a service. Usage: make sh i="php bin/console"

	@docker-compose run --rm -u $(USERID):$(GROUPID) $(PHP_SERVICE) $(i)

logs: ## Shows the logs of a container. Use 'i' variable to filter on a specific container. Usage: make logs i=app

	@docker-compose logs -f $(i)
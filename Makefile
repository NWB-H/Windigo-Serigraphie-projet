DOCKER_COMP = docker compose
PHP_CONT = $(DOCKER_COMP) exec app
NODE = $(DOCKER_COMP) run --rm node

PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
LARAVEL = $(PHP) artisan

up: ## Start the docker hub in detached mode (no logs)
	@$(DOCKER_COMP) up -d

down: ## Stop the docker hub
	@$(DOCKER_COMP) down --remove-orphans

build: ## Builds the Docker images
	@$(DOCKER_COMP) build --pull --no-cache

bash: ## Connect to the FrankenPHP container via bash so up and down arrows go to previous commands
	@$(PHP_CONT) bash

node-bash: ## Connect to node container
	$(NODE) bash

composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

migrate:
	$(LARAVEL) migrate

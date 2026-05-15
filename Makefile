DOCKER_COMP = docker compose
PHP_CONT = $(DOCKER_COMP) exec app
NODE = $(DOCKER_COMP) run --rm node
STRIPE = $(DOCKER_COMP) run --rm stripe

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

stripe-login: ## Authenticate Stripe CLI interactively
	$(STRIPE) login --interactive

stripe-listen: ## Listen to Stripe webhook events and forward to local app
	$(STRIPE) listen --forward-to http://nginx/api/webhook/stripe --events payment_intent.succeeded

stripe-trigger: ## Trigger a Stripe event, pass e= for event type (default: payment_intent.succeeded)
	@$(eval e ?= payment_intent.succeeded)
	$(STRIPE) trigger $(e)

composer: ## Run composer, pass the parameter "c=" to run a given command, example: make composer c='req symfony/orm-pack'
	@$(eval c ?=)
	@$(COMPOSER) $(c)

vendor: ## Install vendors according to the current composer.lock file
vendor: c=install --prefer-dist --no-dev --no-progress --no-scripts --no-interaction
vendor: composer

migrate:
	$(LARAVEL) migrate

fixtures:
	$(LARAVEL) db:seed

generate-js-routes:
	$(LARAVEL) z:g
	$(LARAVEL) w:g

lint:
	$(NODE) npm run lint

format:
	$(NODE) npm run format

# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

# DOCKER TASKS
# Build the container
build: ## Build the container
	docker build

build-nc: ## Build the container without caching
	docker build --no-cache

run: ## Run container on port configured in `.env`
	docker-compose up -d

up: build run ## Run container on port configured in `.env` (Alias to run)

stop: ## Stop and remove a running container
	docker stop $(docker ps -a -q)

remove: ## Stop and remove a running container
	docker rm $(docker ps -a -q)
	

phpsh: ## Open php shell terminal
	docker exec -it php-inter sh
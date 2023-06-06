#!make

dc :=  docker-compose
de := $(dc) exec
sy := $(de) php bin/console
# define standard colors
BLACK        := $(shell tput -Txterm setaf 0)
RED          := $(shell tput -Txterm setaf 1)
GREEN        := $(shell tput -Txterm setaf 2)
YELLOW       := $(shell tput -Txterm setaf 3)
LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
PURPLE       := $(shell tput -Txterm setaf 5)
BLUE         := $(shell tput -Txterm setaf 6)
WHITE        := $(shell tput -Txterm setaf 7)

RESET := $(shell tput -Txterm sgr0)

TARGET_COLOR := $(BLUE)
POUND = \#
.PHONY: no_targets__ info help build deploy doc
	no_targets__:
.DEFAULT_GOAL := help
colors:
	@echo "${BLACK}BLACK${RESET}"
	@echo "${RED}RED${RESET}"
	@echo "${GREEN}GREEN${RESET}"
	@echo "${YELLOW}YELLOW${RESET}"
	@echo "${LIGHTPURPLE}LIGHTPURPLE${RESET}"
	@echo "${PURPLE}PURPLE${RESET}"
	@echo "${BLUE}BLUE${RESET}"
	@echo "${WHITE}WHITE${RESET}"


##
###---------------------------#
###   🐝 Makefile 🐝
###---------------------------#
##
##
install:  build composer-install cc database database-fixtures
##
###----------------------#
###    Docker 🐳
###----------------------#
##
up:   ## Start the docker hub
	$(dc) up -d
down: ## Stop the docker hub
	$(dc) down
build: ## build the docker hub
	$(dc) build
login: ## login to container php
	 $(dc)  exec -u root php bash


###----------------------#
###    Composer 🧙‍
###----------------------#
##
composer-install:  ## Install dependencies
	 $(de)  php  composer install
composer-update: ## Update dependencies
	 $(de)  php  composer update
composer-autoload: ## Autoload Composer
	 $(de)  php  composer dump-autoload

##
###----------------------#
###    Symfony 🎵
###----------------------#
##
cc: ##  cache clear
	 $(sy)   cache:clear

database: ##  Setup database
	$(sy) doctrine:database:drop --if-exists --force --env=dev
	$(sy) doctrine:database:create --env=dev
	$(sy) doctrine:schema:update --force --env=dev
database-fixtures: ## Load the fixtures
	$(sy) doctrine:fixtures:load --no-interaction
##
###----------------------#
###  Coding standards ✨
###----------------------#
##
analyse:  phpcs phpstan
phpcs: up  ## Running phpcs...
   #$(de) php ./vendor/bin/php-cs-fixer fix --using-cache=no
	$(de) php  ./vendor/bin/php-cs-fixer fix --allow-risky yes
phpstan: ## eRunning phpstan...
	$(de) php ./vendor/bin/phpstan analyse --configuration=phpstan.neon


.PHONY: help
help: ## Outputs this help screen
	@echo ""
	@echo "    ${BLACK}:: ${RED}Self-documenting Makefile${RESET} ${BLACK}::${RESET}"
	@echo ""
	@echo " ✔ Document targets by adding '$(POUND)$(POUND) comment' after the target  ✔ "
	@echo ""
	@echo "${BLACK}-----------------------------------------------------------------${RESET}"
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-20s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
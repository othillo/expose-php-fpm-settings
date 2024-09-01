.DEFAULT_GOAL:=help

.PHONY: dependencies
dependencies:
	composer install --no-interaction --no-suggest --no-scripts --ansi

.PHONY: up
up:
	docker compose --file docker-compose.yml --file docker-compose-dev.yml up

.PHONY: down
down:
	docker compose --file docker-compose.yml down

.PHONY: up-prod
up-prod:
	docker compose --file docker-compose.yml up --detach
	@echo "open http://127.0.0.1/health in your browser"

.PHONY: down-prod
down-prod:
	docker compose --file docker-compose.yml down

.PHONY: up-monitoring
up-monitoring:
	docker compose --file docker-compose.yml --file docker-compose-monitoring.yml up --detach

.PHONY: down-monitoring
down-monitoring:
	docker compose --file docker-compose.yml --file docker-compose-monitoring.yml down

.PHONY: tests
tests:
	vendor/bin/phpunit --testdox --exclude-group=none --colors=always

.PHONY: qa
qa: php-cs-fixer-ci phpstan

.PHONY: php-cs-fixer
php-cs-fixer:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --no-interaction --allow-risky=yes --diff --verbose

.PHONY: php-cs-fixer-ci
php-cs-fixer-ci:
	tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run --no-interaction --allow-risky=yes --diff --verbose --stop-on-violation

PHONY: phpstan
phpstan:
	tools/phpstan/vendor/bin/phpstan analyse src/ tests/

PHONY: phpstan-baseline
phpstan-baseline:
	tools/phpstan/vendor/bin/phpstan analyse src/ tests/ --generate-baseline

# Based on https://suva.sh/posts/well-documented-makefiles/
help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

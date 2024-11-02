.DEFAULT_GOAL:=help

.PHONY: dependencies
dependencies:
	composer install --no-interaction --no-suggest --no-scripts --ansi

.PHONY: tests
tests:
	vendor/bin/phpunit --testdox --exclude-group=none --colors=always

.PHONY: phar
phar:
	$$(which php) build-phar.php

# Based on https://suva.sh/posts/well-documented-makefiles/
help:  ## Display this help
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n\nTargets:\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-20s\033[0m %s\n", $$1, $$2 }' $(MAKEFILE_LIST)

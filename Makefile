build:
	docker-compose -f ./.docker/docker-compose.yml build $(c)
serve:
	docker-compose -f ./.docker/docker-compose.yml up $(c)
down:
	docker-compose -f ./.docker/docker-compose.yml down $(c)
unit:
	docker-compose -f ./.docker/docker-compose.yml run php-fpm composer unit
botman-tests:
	docker-compose -f ./.docker/docker-compose.yml run php-fpm composer botman-tests
exec:
	docker-compose -f ./.docker/docker-compose.yml run php-fpm bash
redis:
	docker exec -it botman-redis redis-cli

all: build unit botman-tests

.PHONY: build unit

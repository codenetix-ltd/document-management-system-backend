up:
	docker-compose up -d backend-app

up_dev:
	[ -f ./docker-compose-local.yml ] && \
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml -f ./docker-compose-local.yml up -d backend-app || \
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml up -d backend-app

init:
	docker-compose exec backend-app ./init.sh

init_dev:
	docker-compose -f docker-compose.yml -f docker-compose-dev.yml exec backend-app ./init.sh

test:
	docker exec -it dms-backend-app ./vendor/bin/phpunit tests/Feature

test_coverage:
	docker exec -it dms-backend-app ./vendor/bin/phpunit tests/Feature --coverage-html tests/_reports/coverage

test_stop_fail:
	docker exec dms-backend-app ./vendor/bin/phpunit --stop-on-failure

code_check:
	docker exec -it dms-backend-app ./vendor/bin/phpcs --standard=./phpcs.xml

code_fix:
	docker exec -it dms-backend-app ./vendor/bin/phpcbf --standard=./phpcs.xml
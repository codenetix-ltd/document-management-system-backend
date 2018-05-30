build:
	docker-compose -f docker-compose.yml build

push:
	docker-compose -f docker-compose.yml push

up:
	docker-compose -f docker-compose.yml up -d backend_app mysql

test:
	docker exec -it dms_backend_app ./vendor/bin/phpunit tests/Feature

test_coverage:
	docker exec -it dms_backend_app ./vendor/bin/phpunit tests/Feature --coverage-html tests/_reports/coverage

test_stop_fail:
	docker exec dms_backend_app ./vendor/bin/phpunit --stop-on-failure

code_check:
	docker exec -it dms_backend_app ./vendor/bin/phpcs --standard=./phpcs.xml

code_fix:
	docker exec -it dms_backend_app ./vendor/bin/phpcbf --standard=./phpcs.xml
build:
	docker-compose -f docker-compose.yml build

push:
	docker-compose -f docker-compose.yml push

up:
	docker-compose -f docker-compose.yml up -d app

test:
	docker exec -it dms_app ./vendor/bin/phpunit tests/Feature

test_coverage:
	docker exec -it dms_app ./vendor/bin/phpunit tests/Feature --coverage-html tests/_reports/coverage

test_stop_fail:
	docker exec dms_app ./vendor/bin/phpunit --stop-on-failure

code_check:
	docker exec -it dms_app ./code_check.sh
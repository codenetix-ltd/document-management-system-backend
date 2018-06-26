build:
	export LOCAL_IP="$(shell ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p' | head -n1)"; \
	docker-compose -f docker-compose.yml build

push:
	docker-compose -f docker-compose.yml push

up:
	docker-compose -f docker-compose.yml -f docker-compose.share-ports.yml up -d backend-app mysql

test:
	docker exec -it dms_backend_app ./vendor/bin/phpunit tests/Feature

test_coverage:
	docker exec -it dms_backend_app ./vendor/bin/phpunit tests/Feature --coverage-html tests/_reports/coverage

test_stop_fail:
	docker exec dms_backend_app ./vendor/bin/phpunit --stop-on-failure

code_check:
	docker exec -it dms-backend-app ./vendor/bin/phpcs --standard=./phpcs.xml

code_fix:
	docker exec -it dms-backend-app ./vendor/bin/phpcbf --standard=./phpcs.xml
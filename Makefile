generate_validation:
	make update_schema
	docker-compose -f docker-compose-local.yml pull validation-generator
	docker-compose -f docker-compose-local.yml up validation-generator

update_schema:
	docker-compose -f docker-compose-local.yml pull schema
	docker-compose -f docker-compose-local.yml up schema

start:
	docker-compose -f docker-compose-local.yml up -d app

test:
	docker exec -it dms_app ./vendor/bin/phpunit

test_coverage:
	docker exec -it dms_app ./vendor/bin/phpunit --coverage-html /coverage

test_stop_fail:
	docker exec dms_app ./vendor/bin/phpunit --stop-on-failure

test_api:
	make update_schema
	docker-compose -f docker-compose-local.yml pull testing_api
	docker-compose -f docker-compose-local.yml up testing_api
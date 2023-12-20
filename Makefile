setup:
	@make build
	@make start
	@make composer-update
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
down:
	docker-compose down
start:
	docker-compose up -d
composer-update:
	docker exec crud_bacend_app bash -c "composer update"
migrate:
	docker exec crud_bacend_app bash -c "php artisan migrate"
seed:
	docker exec crud_bacend_app bash -c "php artisan db:seed"
passport:
	docker exec crud_bacend_app bash -c "php artisan passport:install"
shell:
	docker exec -it crud_bacend_app bash

start:
	./vendor/bin/sail up -d

down:
	./vendor/bin/sail down

composer-update:
	./vendor/bin/sail composer update

migrate:
	./vendor/bin/sail php artisan migrate

passport:
	./vendor/bin/sail php artisan passport:install

seed:
	./vendor/bin/sail php artisan db:seed

key:
	./vendor/bin/sail php artisan key:generate

setup:
    @make start
    @make key
    @make migrate
    @make seed
    @make passport

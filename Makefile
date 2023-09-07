init: docker-up backend-seed chmod link npm-run

chmod:
	sudo chmod -R 777 storage/
link:
	php artisan storage:link
npm-run:
	npm run dev


docker-up:
	docker-compose up -d



docker-down:
	docker-compose down

backend-migrations:
	docker exec -it laravel-ticket-system_php-fpm_1 php artisan migrate

composer-install:
	docker exec -it laravel-ticket-system_php-cli_1 composer install
backend-seed:
	docker exec -it laravel-ticket-system_php-fpm_1 php artisan migrate:fresh --seed

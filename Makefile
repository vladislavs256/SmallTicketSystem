
chmod:
	sudo chmod -R 777 storage/
link:
	php artisan storage:link
init:
	docker-compose up -d
	npm run dev


setup: init backend-seed chmod link

backend-migrations:
	docker exec -it laravel-ticket-system_php-fpm_1 php artisan migrate

backend-seed:
	docker exec -it laravel-ticket-system_php-fpm_1 php artisan migrate:fresh --seed

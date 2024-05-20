init: docker-build docker-up composer-install copy-env backend-seed chmod link encryption-key node-install npm-run

up: docker-down docker-build docker-up npm-run

chmod:
	sudo chmod -R 777 storage/
	sudo chmod -R 777 data/
link:
	docker exec -it ticket_php_cli php artisan storage:link
copy-env:
	cp .env.example .env

docker-up:
	docker-compose up -d
docker-build:
	docker-compose build

node-install:
	docker exec -it ticket_nodejs npm install

npm-run:
	docker exec -it ticket_nodejs npm run dev

give-rules:
	sudo chmod 755 -R node_modules/

docker-down:
	docker-compose down

backend-migrations:
	docker exec -it ticket_php_fpm php artisan migrate

encryption-key:
	docker exec -it ticket_php_cli php artisan key:generate

composer-install:
	docker exec -it ticket_php_cli composer install
backend-seed:
	docker exec -it ticket_php_fpm php artisan migrate:fresh --seed

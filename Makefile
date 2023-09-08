init: docker-build docker-up composer-install copy-env backend-seed chmod link node-run

chmod:
	sudo chmod -R 777 storage/
link:
	php artisan storage:link
npm-run:
	npm run dev
copy-env:
	cp .env.example .env

docker-up:
	docker-compose up -d
docker-build:
	docker-compose build


node-run:
	docker exec -it smallticketsystem_frontend-nodejs_1 npm install &&  npm run dev

docker-down:
	docker-compose down

backend-migrations:
	docker exec -it smallticketsystem_php-fpm_1 php artisan migrate

encryption-key:
	docker exec -it smallticketsystem_php-cli_1 php artisan key:generate

composer-install:
	docker exec -it smallticketsystem_php-cli_1 composer install
backend-seed:
	docker exec -it smallticketsystem_php-fpm_1 php artisan migrate:fresh --seed

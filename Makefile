
chmod:
	sudo chmod -R 777 storage/
link:
	php artisan storage:link
init:
	docker-compose up -d
	npm run dev

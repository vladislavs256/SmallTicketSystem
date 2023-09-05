
chmod:
	sudo chmod 777 -R storage/
link:
	php artisan storage:link
init:
	docker-compose up -d
	npm run dev


chmod:
	sudo chmod 777 -R storage/

init:
	docker-compose up -d
	npm run dev

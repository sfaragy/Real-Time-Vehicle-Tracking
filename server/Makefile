.PHONY: build stop start seed logs app-login migrate keygenerate restart seed composer-install

build: build-image start composer-install create-env-files set-storage-permission stop

build-image: stop
	docker-compose -f docker-compose.yml build

stop:
	docker-compose -f docker-compose.yml down

start: stop
	docker-compose -f docker-compose.yml up --remove-orphans -d

restart: stop start

logs:
	docker exec server_web_1 storage/logs --tail=10 -f $(c)

app-login:
	docker exec -it server_web_1 /bin/bash

migrate: start migrate-db seed

migrate-db:
	docker exec server_web_1 php artisan migrate

seed:
	docker exec server_web_1 php artisan migrate:refresh --seed


keygenerate:
	docker exec server_web_1 php artisan key:generate

redis-login:
	docker exec -it server_redis_1 redis-cli

add-local-host-alias:
	sudo sed -i /lmw.local.com/d /etc/hosts
	echo "127.0.0.1 lmw.local.com" | sudo tee -a /etc/hosts >/dev/null

composer-install:
	docker exec server_web_1 composer install
	docker exec server_web_1 composer dump-autoload

create-env-files:
	@echo `touch .env`
	@echo `touch .env.testing`

set-storage-permission:
	docker exec -it server_web_1 sh -c 'cd /var/www/html && chmod 777 storage -R && chmod -R 777 storage/logs && chmod -R 777 bootstrap/cache'

create-db:
	@echo "Prepare container to use DB..."
	docker-compose -f docker-compose.yml up -d db
	@echo "Wait until mysql docker image up and running?"
	while [ $$(docker inspect --format "{{json .State.Status }}" $$(docker-compose -f docker-compose.yml ps -q db)) != "\"running\"" ]; do printf "."; sleep 1; done

	@echo "Drop DB if exists"
	docker exec -it lmw_pgs sh -c 'psql -U lmw_pgs -W -c "CREATE DATABASE lmw_pgs;"'
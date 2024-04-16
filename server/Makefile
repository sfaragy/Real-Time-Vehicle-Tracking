.PHONY: build stop start seed logs app-login migrate keygenerate restart seed

build: stop
	docker-compose -f docker-compose.yml build

stop:
	docker-compose -f docker-compose.yml down

start: stop
	docker-compose -f docker-compose.yml up --remove-orphans -d

restart: stop start

logs: 
	docker-compose -f docker-compose.yml server_web_1 storage/logs --tail=10 -f $(c)

app-login:
	docker exec -it server_web_1 /bin/bash

migrate:
	docker-compose run server_web_1 php artisan migrate

seed:
	docker-compose run server_web_1 php artisan migrate:refresh --seed


keygenerate:
	docker-compose exec server_web_1 php artisan key:generate

redis-login:
	docker exec -it server_redis_1 redis-cli

add-local-host-alias:
	sudo sed -i /lmw.local.com/d /etc/hosts
	echo "127.0.0.1 lmw.local.com" | sudo tee -a /etc/hosts >/dev/null
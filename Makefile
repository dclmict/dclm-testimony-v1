up:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

dev:
	cp ./ops/.env.dev ./src/.env
	cp ./docker-compose-dev.yml ./src/docker-compose.yml
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

prod:
	cp ./docker-compose-prod.yml ./src/docker-compose.yml
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

build:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up --detach --build

down:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down

start:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env start

stop:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env stop

restart:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env.dev restart

destroy:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env down --volumes

shell:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src bash

composer:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src composer install

key:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src php artisan key:generate

migrate:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src php artisan migrate

fresh:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src php artisan migrate:fresh

seed:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src php artisan db:seed

storage:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec events-src php artisan storage:link

db:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec events-src php artisan tinker

version:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-src php artisan --version

log:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env logs -f testimony-src
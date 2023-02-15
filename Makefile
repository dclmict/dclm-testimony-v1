up:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env up -d

dev:
	cp ./ops/.env.dev ./app/.env
	cp ./docker-compose-dev.yml ./app/docker-compose.yml
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env up -d

prod:
	cp ./docker-compose-prod.yml ./app/docker-compose.yml
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env up -d

build:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env up --detach --build

down:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env down

start:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env start

stop:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env stop

restart:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env.dev restart

destroy:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env down --volumes

shell:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app bash

composer:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app composer install

key:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app php artisan key:generate

migrate:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app php artisan migrate

fresh:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app php artisan migrate:fresh

seed:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app php artisan db:seed

storage:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec events-app php artisan storage:link

db:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec events-app php artisan tinker

version:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env exec testimony-app php artisan --version

log:
	docker compose -f ./app/docker-compose.yml --env-file ./app/.env logs -f testimony-app
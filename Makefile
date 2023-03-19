build:
	@if docker images | grep -q opeoniye/dclm-testimony; then \
		echo -e "Removing \033[31mopeoniye/dclm-testimony\033[0m image"; \
		y | docker image prune --filter="dangling=true"; \
		docker image rm opeoniye/dclm-testimony; \
		echo -e "Building \033[31mopeoniye/dclm-testimony\033[0m image"; \
		docker build -t opeoniye/dclm-testimony:latest .; \
		docker images | grep opeoniye/dclm-testimony; \
	else \
		echo -e "Building \033[31mopeoniye/dclm-testimony\033[0m image"; \
		docker build -t opeoniye/dclm-testimony:latest .; \
		docker images | grep opeoniye/dclm-testimony; \
	fi

push:
	cat ops/docker/pin | docker login -u opeoniye --password-stdin
	docker push opeoniye/dclm-testimony:latest

up:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

dev:
	cp ./ops/.env.dev ./src/.env
	cp ./docker-dev.yml ./src/docker-compose.yml
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

prod:
	cp ./ops/.env.prod ./src/.env
	cp ./docker-prod.yml ./src/docker-compose.yml
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env up -d

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
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app bash

composer:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app composer install

key:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan key:generate

migrate:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan migrate

fresh:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan migrate:fresh

seed:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan db:seed

storage:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec events-app php artisan storage:link

db:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec events-app php artisan tinker

version:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan --version

log:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env logs -f testimony-app
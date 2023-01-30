exec:
	docker compose exec -it testimony-app sh
up:
	docker compose --env-file ./src/.env.dev up --detach
dev:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev up --detach
prod:
	docker compose -f docker-compose-prod.yml --env-file ./src/.env up --detach
down:
	docker compose down
start:
	docker compose start
restart:
	docker compose restart
stop:
	docker compose stop
log:
	docker compose logs -f testimony-app
destroy:
	docker compose down --volumes
build:
	docker compose up --detach --build
key:
 	docker compose exec testimony-app php artisan key:generate
migrate:
	docker compose exec testimony-app php artisan migrate
fresh:
	docker compose exec testimony-app php artisan migrate:fresh
seed:
 	docker compose exec testimony-app php artisan db:seed
version:
	docker compose exec testimony-app php artisan artisan --version
bams:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev exec -it testimony-app sh
aws:
	docker compose -f docker-compose-prod.yml --env-file ./src/.env exec -it testimony-app sh
dev:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev up --detach
prod:
	docker compose -f docker-compose-prod.yml --env-file ./src/.env up --detach
ddev:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev down
dprod:
	docker compose -f docker-compose-prod.yml --env-file ./src/.env down
start:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev start
restart:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev restart
stop:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev stop
logdev:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev logs -f testimony-app
logprod:
	docker compose -f docker-compose-prod.yml logs -f --env-file ./src/.env testimony-app
destroy:
	docker compose down --volumes
build:
	docker compose -f docker-compose-dev.yml --env-file ./src/.env.dev up --detach --build
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
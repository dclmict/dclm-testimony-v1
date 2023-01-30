bams:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec -it testimony-app sh
aws:
	docker compose -f docker-compose-prod.yml --env-file ./app/.env exec -it testimony-app sh
dev:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev up --detach
prod:
	docker compose -f docker-compose-prod.yml --env-file ./app/.env up --detach
ddev:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev down
dprod:
	docker compose -f docker-compose-prod.yml --env-file ./app/.env down
start:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev start
restart:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev restart
stop:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev stop
logdev:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev logs -f testimony-app
logprod:
	docker compose -f docker-compose-prod.yml logs -f --env-file ./app/.env testimony-app
destroy:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev down --volumes
build:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev up --detach --build
key:
 	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec testimony-app php artisan key:generate
appkey:
 	docker compose -f docker-compose-prod.yml --env-file ./app/.env exec testimony-app php artisan key:generate
migrate:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec testimony-app php artisan migrate
appdata:
	docker compose -f docker-compose-prod.yml --env-file ./app/.env exec testimony-app php artisan migrate
fresh:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec testimony-app php artisan migrate:fresh
appfresh:
	docker compose -f docker-compose-prod.yml --env-file ./app/.env exec testimony-app php artisan migrate:fresh
seed:
 	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec testimony-app php artisan db:seed
appseed:
 	docker compose -f docker-compose-prod.yml --env-file ./app/.env exec testimony-app php artisan db:seed
version:
	docker compose -f docker-compose-dev.yml --env-file ./app/.env.dev exec testimony-app php artisan artisan --version
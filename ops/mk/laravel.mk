key:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan key:generate

routes:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan route:list

storage:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan storage:link

migrate:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan migrate

migrate-fresh:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan migrate:fresh

seed:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan db:seed

tinker:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan tinker

clear:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan cache:clear

optimize:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan optimize


info:
	@docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) php artisan --version

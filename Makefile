repo:
	echo "\033[31mEnter app code folder name:\033[0m ";
	read -r code; \
	cd ~/dev/web/dclm/$$code; \
	git init && git add . && git commit -m "DCLM Academy"; \
	echo "\033[31mEnter Github repo name :\033[0m ";
	read -r repo; \
	gh repo create dclmict/$$repo --public --source=. --remote=origin; \
	git push --set-upstream origin main

git:
	@if git status --porcelain | grep -q '^??'; then \
		git add .; \
		echo "\033[31mUntracked files found::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg1; \
		git commit -m "$$msg1"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo "\033[32mPushing commit to GitHub...\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo "\033[32m Nothing to be done. Thank you...\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo "\033[32m No choice. Exiting script...\033[0m"; \
				exit 1; \
				;; \
		esac \
	else \
		echo "\033[31mThere are no new files::\033[0m \033[32mPlease enter commit message:\033[0m"; \
		read -r msg2; \
		git commit -am "$$msg2"; \
		read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
		case "$$choice" in \
			yes|Y|y) \
				echo "\033[32mPushing commit to GitHub...\033[0m"; \
				git push; \
				;; \
			no|N|n) \
				echo "\033[32m Nothing to be done. Thank you...\033[0m"; \
				exit 0; \
				;; \
			*) \
				echo "\033[32m No choice. Exiting script...\033[0m"; \
				exit 1; \
				;; \
		esac \
	fi

build:
	@if docker images | grep -q opeoniye/dclm-testimony; then \
		echo "Removing \033[31mopeoniye/dclm-testimony\033[0m image"; \
		echo y | docker image prune --filter="dangling=true"; \
		docker image rm opeoniye/dclm-testimony; \
		echo "Building \033[31mopeoniye/dclm-testimony\033[0m image"; \
		docker build -t opeoniye/dclm-testimony:latest .; \
		docker images | grep opeoniye/dclm-testimony; \
	else \
		echo "Building \033[31mopeoniye/dclm-testimony\033[0m image"; \
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
	docker pull opeoniye/dclm-testimony:latest
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
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan storage:link

db:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan tinker

info:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env exec testimony-app php artisan --version

log:
	docker compose -f ./src/docker-compose.yml --env-file ./src/.env logs -f testimony-app
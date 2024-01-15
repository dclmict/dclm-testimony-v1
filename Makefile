# https://makefiletutorial.com/

SHELL := /bin/bash

# copy .env file based on env (auto)
SRC := $(shell os=$$(hostname); \
	if [ "$$os" = "dclm" ]; then \
		cp ./ops/dclm-prod.env ./src/.env; \
	elif [ "$$os" = "dclmict" ]; then \
		cp ./ops/dclm-dev.env ./src/.env; \
	else \
		cp ./ops/bams-dev.env ./src/.env; \
	fi)

# load env file
include ./src/.env

## include makefiles
# Remove double quotes
DL_STACK := $(subst ",,${DL_STACK})

ifeq ($(DL_STACK),laravel)
	include ./ops/sh/laravel.mk
endif

# copy .env file based on env (prompt)
env: 
	@os=$$(hostname); \
	if [ "$$os" = "dclm" ]; then \
		cp ./ops/dclm-prod.env ./src/.env; \
	elif [ "$$os" = "dclmict" ]; then \
		cp ./ops/dclm-dev.env ./src/.env; \
	else \
		if [[ "$$os" != "dclm" && "$$os" != "dclmict" ]]; then \
			make copy-env; \
		else \
			cp ./ops/bams-dev.env ./src/.env; \
		fi \
	fi

copy-env:
	@chmod +x ./ops/sh/copy-env-file.sh
	@./ops/sh/copy-env-file.sh

repo:
	@echo "What do you want to do?:"; \
	echo "1. Create local git repo"; \
	echo "2. Create remote repo on GitHub"; \
	echo "3. Rename remote repo on GitHub"; \
	read -p "Enter a number to select your choice: " git_choice; \
	if [ $$git_choice -eq 1 ]; then \
		make repo-gitignore; \
		make repo-init; \
	elif [ $$git_choice -eq 2 ]; then \
		make repo-name; \
	elif [ $$git_choice -eq 3 ]; then \
		make repo-rename; \
	else \
		echo "Invalid choice"; \
		exit 1; \
	fi

repo-init:
	@read -p "Do you want to initialise this folder? (yes|no): " repo_init; \
	case "$$repo_init" in \
		yes|Y|y) \
			if [ -d .git ]; then \
				echo -e "\033[31mCurrent directory already initialised \033[0m\n"; \
			else \
				echo -e "\033[32mPlease enter initial commit message: \033[0m\n"; \
				read -r commitMsg; \
				git init && git add . && git commit -m "$$commitMsg"; \
			fi \
			;; \
		no|N|n) \
			echo -e "\033[32mNothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

repo-name:
	@read -p "Do you want to create a github repo? (yes|no): " repo_name; \
	case "$$repo_name" in \
		yes|Y|y) \
			read -p "Enter GitHub user: " ghUser; \
			read -p "Enter GitHub repo name: " ghName; \
			chmod +x ./ops/sh/gh-repo-check.sh; \
			result="$$(./ops/sh/gh-repo-check.sh $$ghUser/$$ghName)"; \
			if [ $$result -eq 200 ]; then \
				echo -e "\033[31mGitHub repo exists. I stop here. \033[0m\n"; \
			else \
				echo "Which type of repository are you creating?:"; \
				echo "1. Private repo"; \
				echo "2. Public repo"; \
				read -p "Enter a number to select your choice: " repoType; \
				if [ $$repoType -eq 1 ]; then \
					REPO=private; \
				elif [ $$repoType -eq 2 ]; then \
					REPO=public; \
				else \
					echo "Invalid choice"; \
					exit 1; \
				fi; \
				gh repo create $$ghUser/$$ghName --$$REPO --source=. --remote=origin; \
			fi; \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32m No choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

repo-rename:
	@read -p "Do you want to rename this repo? (yes|no): " repo_scan; \
	case "$$repo_scan" in \
		yes|Y|y) \
			echo -e "\033[32mRenaming repo ...\033[0m\n"; \
			chmod +x ./ops/sh/gh-repo-rename.sh; \
			./ops/sh/gh-repo-rename.sh; \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

repo-scan:
	@read -p "Do you want to scan this repo? (yes|no): " repo_scan; \
	case "$$repo_scan" in \
		yes|Y|y) \
			echo -e "\033[32mScanning repo for secrets...\033[0m\n"; \
			ggshield secret scan repo .; \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

repo-gitignore:
	@echo '# files' > .gitignore
	@echo '.env' >> .gitignore
	@echo '.cache_ggshield' >> .gitignore
	@echo 'dclm-events' >> .gitignore
	@echo 'ops/bams-dev.env' >> .gitignore
	@echo 'ops/dclm-dev.env' >> .gitignore
	@echo 'ops/dclm-prod.env' >> .gitignore
	@echo 'ops/dclm-v1.env' >> .gitignore
	@echo '' >> .gitignore
	@echo '# folders' >> .gitignore
	@echo '_' >> .gitignore

git: gh-envfile-set gh-secret-set gh-variable-set
	@if git status --porcelain | grep -q "^??"; then \
		make commit-1; \
		make git-push; \
	elif git status --porcelain | grep -qE '[^ADMR]'; then \
		make commit-2; \
		make git-push; \
	elif [ -z "$$(git status --porcelain)" ]; then \
		make git-push; \
	else \
		echo -e "\033[31m Unknown status. Aborting...\033[0m\n"; \
		exit 0; \
	fi

commit-1:
	@echo -e "\033[31mUntracked files found::\033[0m \033[32mPlease enter commit message:\033[0m"; \
	read -r msg1; \
	git add -A; \
	git commit -m "$$msg1"; \

commit-2:
	@echo -e "\033[31mModified files found...\033[0m \033[32mPlease enter commit message:\033[0m"; \
	read -r msg2; \
	git commit -am "$$msg2"

gh-secret-list:
	@gh secret list

gh-secret-set: gh-secret-rm
	@read -p "Do you want to set repo secrets? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mSetting repo secrets...\033[0m\n"; \
			chmod +x ./ops/sh/gh-secret-set.sh; \
			./ops/sh/gh-secret-set.sh $(DL_ENV); \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

gh-secret-rm:
	@read -p "Do you want to delete repo secrets? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mDeleting repo secrets...\033[0m\n"; \
			chmod +x ./ops/sh/gh-secret-rm.sh; \
			./ops/sh/gh-secret-rm.sh $(DL_ENV); \
			;; \
		no|N|n) \
			echo -e "\033[32mNothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

gh-variable-set: gh-variable-rm
	@read -p "Do you want to set repo variables? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mSetting repo variables...\033[0m\n"; \
			chmod +x ./ops/sh/gh-variable-set.sh; \
			./ops/sh/gh-variable-set.sh; \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

gh-variable-rm:
	@read -p "Do you want to delete repo variables? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mDeleting repo variables...\033[0m\n"; \
			chmod +x ./ops/sh/gh-variable-rm.sh; \
			./ops/sh/gh-variable-rm.sh $(DL_ENV); \
			;; \
		no|N|n) \
			echo -e "\033[32mNothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

gh-envfile-set: env
	@read -p "Do you want to generate env in workflow? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mFilling env file in workflow...\033[0m\n"; \
			chmod +x ./ops/sh/gh-envfile-set.sh; \
			./ops/sh/gh-envfile-set.sh; \
			;; \
		no|N|n) \
			echo -e "\033[32mOkay. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

git-push: repo-scan
	@read -p "Do you want to push your commit to GitHub? (yes|no): " choice; \
	case "$$choice" in \
		yes|Y|y) \
			echo -e "\033[32mPushing commit to GitHub...\033[0m\n"; \
			git push; \
			;; \
		no|N|n) \
			echo -e "\033[32mNothing to be done. Thank you...\033[0m\n"; \
			exit 0; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m\n"; \
			exit 1; \
			;; \
	esac

image:
	@if [ "$(docker images -qf "dangling=true")" ]; then \
		echo -e "\033[31mRemoving dangling images...\033[0m"; \
		docker image prune -f; \
	fi
	@if docker image inspect $(DL_DIN) &> /dev/null; then \
		echo -e "\033[31mDeleting existing image...\033[0m"; \
		docker rmi $(DL_DIN); \
	fi
	@echo -e "\033[32mBuilding $(DL_DIN) image\033[0m"
	@docker build -t $(DL_DIN) -f $(DL_DFILE) .
	@docker images | grep $(DL_IU)/$(DL_IN)

image-push:
	@echo ${DL_DLP} | docker login -u ${DL_DLU} --password-stdin
	@docker push $(DL_DIN)

create-compose-dev:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(DL_CN):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${DL_CN}" >> ./src/docker-compose.yml
	@echo "    image: \$${DL_DIN}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(DL_COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(DL_COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - .:/var/www" >> ./src/docker-compose.yml
	@echo "      - $(DL_CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(DL_CERT_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "    restart: always" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(DL_COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(DL_COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."

create-compose-prod:
	@echo "Generating docker-compose.yml..."
	@echo "services:" > ./src/docker-compose.yml
	@echo "  $(DL_CN):" >> ./src/docker-compose.yml
	@echo "    container_name: \$${DL_CN}" >> ./src/docker-compose.yml
	@echo "    image: \$${DL_DIN}" >> ./src/docker-compose.yml
	@echo "    env_file: .env" >> ./src/docker-compose.yml
	@echo "    ports:" >> ./src/docker-compose.yml
	@echo "      - $(DL_COMPOSE_PORT)" >> ./src/docker-compose.yml
	@echo "    networks:" >> ./src/docker-compose.yml
	@echo "      - $(DL_COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    volumes:" >> ./src/docker-compose.yml
	@echo "      - $(DL_CERT):/var/ssl/cert.pem" >> ./src/docker-compose.yml
	@echo "      - $(DL_CERT_KEY):/var/ssl/key.pem" >> ./src/docker-compose.yml
	@echo "    restart: always" >> ./src/docker-compose.yml
	@echo "    working_dir: /var/www" >> ./src/docker-compose.yml
	@echo "networks:" >> ./src/docker-compose.yml
	@echo "  $(DL_COMPOSE_NETWORK):" >> ./src/docker-compose.yml
	@echo "    name: $(DL_COMPOSE_NETWORK)" >> ./src/docker-compose.yml
	@echo "    external: true" >> ./src/docker-compose.yml
	@echo "Docker-compose file generated successfully."

up:
	@echo -e "\033[31mStarting container in $(DL_ENV_ENV) environment...\033[0m"
	@if [ "$(DL_ENV_ENV)" = "bams-dev" ]; then \
		make create-compose-dev; \
		docker compose -f $(DL_DCF) up -d; \
	else \
		make create-compose-prod; \
		docker pull $(DL_DIN); \
		docker compose -f $(DL_DCF) up -d; \
	fi

down:
	@docker compose -f $(DL_DCF) down

start:
	@docker compose -f $(DL_DCF) start

restart:
	@docker compose -f $(DL_DCF) restart

stop:
	@docker compose -f $(DL_DCF) stop

ps:
	@docker compose -f $(DL_DCF) ps

stats:
	@docker compose -f $(DL_DCF) top

log:
	@docker compose -f $(DL_DCF) logs -f $(DL_CN)

sh:
	@docker compose -f $(DL_DCF) exec -it $(DL_CN) bash

new:
	@git restore .
	@git pull

run:
	@echo -e "\033[31mEnter command to run inside container: \033[0m"; \
	read -r cmd; \
	docker compose -f $(DL_DCF) exec $(DL_CN) bash -c "$$cmd"

play:
	@docker run -it --rm --name ubuntu -v "$$(pwd)":/myapp -w /myapp ubuntu:bams

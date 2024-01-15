# https://makefiletutorial.com/

SHELL:=/bin/bash
# colours
RED:=\033[31m
RED_BOLD=\033[1;31m
BLUE:=\033[34m
BLUE_BOLD=\033[1;34m
GREEN:=\033[32m
GREEN_BOLD=\033[1;32m
YELLOW:=\033[133m
YELLOW_BOLD=\033[1;33m
RESET:=\033[0m

.ONESHELL:
SRC := $(shell \
  os=$$(hostname); \
  if [ "$$os" = "dclm" ]; then \
    cp ./ops/dclm-prod.env ./src/.env; \
	fi; \
  if [ "$$os" = "dclmict" ]; then \
    cp ./ops/dclm-dev.env ./src/.env; \
	fi; \
  if [[ "$$os" != "dclm" && "$$os" != "dclmict" ]]; then \
		branch=$$(git rev-parse --abbrev-ref HEAD); \
		if [[ $$branch == "bams" ]]; then \
			cp ./ops/bams.env ./src/.env; \
		elif [[ $$branch == "release/dev" ]]; then \
			cp ./ops/dclm-dev.env ./src/.env; \
		elif [[ $$branch == "release/prod" ]]; then \
			cp ./ops/dclm-prod.env ./src/.env; \
		else \
			cp ./ops/bams.env ./src/.env; \
		fi; \
  fi; \
  chmod +x ./ops/sh/app.sh)

all: mk

# load env file
include ./src/.env

# load makefiles
include ./ops/mk/0-init.mk
include ./ops/mk/1-build.mk
include ./ops/mk/2-push.mk
include ./ops/mk/3-run.mk
include ./ops/mk/4-utils.mk

# remove double quotes from variable
DL_APP_STACK := $(subst ",,${DL_APP_STACK})

# include app stack
ifeq ($(DL_APP_STACK),laravel)
	include ./ops/mk/laravel.mk
endif

mk:
	@echo ""

init: init-app

app: build-app

push: deploy-app

run: run-app

utils: app-utils

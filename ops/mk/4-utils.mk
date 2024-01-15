app-utils:
	@\
	echo "1. Copy envfile"; \
	echo "2. Create Nginx vhost"
	echo "3. Scan local git repo"; \
	echo "4. Rename local git repo"; \
	echo "5. Rename GitHub repo"; \
	echo "6. Check GitHub repo"; \
	echo "7. View GitHub repo visibility"; \
	read -p "Enter a number to select your choice: " ops_utils; \
	if [ $$ops_utils -eq 1 ]; then \
		./ops/sh/app.sh; 0; \
	elif [ $$ops_utils -eq 2 ]; then \
		./ops/sh/app.sh; 12; \
	elif [ $$ops_utils -eq 3 ]; then \
		./ops/sh/app.sh; 13; \
	elif [ $$ops_utils -eq 4 ]; then \
		./ops/sh/app.sh; 14; \
	elif [ $$ops_utils -eq 5 ]; then \
		./ops/sh/app.sh; 15; \
	elif [ $$ops_utils -eq 6 ]; then \
		./ops/sh/app.sh; 16; \
	elif [ $$ops_utils -eq 7 ]; then \
		./ops/sh/app.sh; 17; \
	else \
		echo "Invalid choice"; \
		exit 1; \
	fi

cmd:
	@echo -e "\033[31mEnter command to run inside container: \033[0m"; \
	read -r cmd; \
	docker compose -f $(COMPOSE_FILE) exec $(DL_APP_NAME) bash -c "$$cmd"

play:
	@docker run -it --rm --name ubuntu -v "$$(pwd)":/myapp -w /myapp ubuntu:bams

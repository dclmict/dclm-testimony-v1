build-app:
	@\
	echo "1. Commit git repo"; \
	echo "2. Build docker image"; \
	read -p "Enter a number to select your choice: " build_app; \
	if [ $$build_app -eq 1 ]; then \
		./ops/sh/app.sh 3; \
	elif [ $$build_app -eq 2 ]; then \
		./ops/sh/app.sh 4; \
	else \
		echo "Invalid choice"; \
	fi

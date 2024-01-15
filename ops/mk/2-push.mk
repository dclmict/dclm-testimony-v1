deploy-app:
	@\
	echo "1. Push git repo"; \
	echo "2. Push docker image"; \
	read -p "Enter a number to select your choice: " deploy_app; \
	if [ $$deploy_app -eq 1 ]; then \
		./ops/sh/app.sh 5; \
	elif [ $$deploy_app -eq 2 ]; then \
		./ops/sh/app.sh 6; \
	else \
		echo "Invalid choice"; \
	fi

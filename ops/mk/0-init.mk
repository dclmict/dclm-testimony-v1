init-app:
	@\
	echo "1. Create local repo"; \
	echo "2. Create GitHub repo"; \
	read -p "Enter a number to select your choice: " init; \
	if [ $$init -eq 1 ]; then \
		make -s gitignore; \
		./ops/sh/app.sh 1; \
	elif [ $$init -eq 2 ]; then \
		./ops/sh/app.sh 2; \
	else \
		echo "Invalid choice"; \
		exit 1; \
	fi

gitignore:
	@read -p "Do you want to create .gitignore file? (yes|no): " gitignore; \
	case "$$gitignore" in \
		yes|Y|y) \
			echo '# files' > .gitignore
			echo '.env' >> .gitignore
			echo '.cache_ggshield' >> .gitignore
			echo 'dclm-events' >> .gitignore
			echo 'ops/bams-dev.env' >> .gitignore
			echo 'ops/dclm-dev.env' >> .gitignore
			echo 'ops/dclm-prod.env' >> .gitignore
			echo 'ops/dclm-v1.env' >> .gitignore
			echo '' >> .gitignore
			echo '# folders' >> .gitignore
			echo '_' >> .gitignore
			;; \
		no|N|n) \
			echo -e "\033[32mNothing to be done. Thank you...\033[0m"; \
			;; \
		*) \
			echo -e "\033[32mNo choice. Exiting script...\033[0m"; \
			exit 1; \
			;; \
	esac

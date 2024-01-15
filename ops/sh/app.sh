#!/bin/bash

# add envfile to shell
dotenv='./src/.env'
source $dotenv

# colours
RED='\033[31m'
RED_BOLD='\033[1;31m'
BLUE='\033[34m'
BLUE_BOLD='\033[1;34m'
GREEN='\033[32m'
GREEN_BOLD='\033[1;32m'
YELLOW='\033[33m'
YELLOW_BOLD='\033[1;33m'
RESET='\033[0m'

nginx_config() {
  export DL_APP_NAME DL_APP_NGX_DOCROOT DL_APP_NGX_SERVER_NAME DL_APP_NGX_INDEX
  # Generate config 
  envsubst '${DL_APP_NAME},${DL_APP_NGX_DOCROOT},${DL_APP_NGX_SERVER_NAME},${DL_APP_NGX_INDEX}' < ./ops/nginx/app.template > ./ops/nginx/app.conf
}

# function to check which git branch
git_branch() {
  # Get the current Git branch
  branch=$(git rev-parse --abbrev-ref HEAD)

  # Check if branch is release/dev or release/prod
  if [[ $branch != "release/dev" ]] && [[ $branch != "release/prod" ]]; then
    # Prompt the user to select a branch  
    echo -e "Current branch is ${RED}$branch.${RESET} You can only deploy on ${GREEN}release/dev${RESET} or ${GREEN}release/prod${RESET}"
    echo -e "Please select branch:"
    echo -e "1) ${YELLOW}release/dev${RESET}" 
    echo -e "2) ${YELLOW}release/prod${RESET}"
    read -p "Enter choice: " choice

    # Switch based on choice
    case $choice in
      1) 
        echo -e "Switching to ${GREEN}release/dev${RESET} branch"
        git switch release/dev
        if [ $? -eq 0 ]; then
          :
        else
          echo -e "Could not switch to ${RED}release/dev${RESET} branch\n"
          exit 1
        fi
        ;;
      2)
        echo "Switching to ${GREEN}release/prod${RESET} branch" 
        git switch release/prod
        if [ $? -eq 0 ]; then
          :
        else
          echo -e "Could not switch to ${RED}release/prod${RESET} branch\n"
          exit 1
        fi
        ;;
      *)
        echo "Invalid choice" >&2
        exit 1
        ;;
    esac
  else 
    echo -e "Git Repo: You're on ${GREEN}$branch${RESET} branch"
  fi
}

# function to check if there are uncommitted changes in repo
commit_status() {
  # Check if the current directory is a Git repository
  if [ -d .git ] || git rev-parse --git-dir > /dev/null 2>&1; then
    :
  else
    echo "This is not a Git repository."
    exit 1
  fi

  # Check if the working tree is clean
  if [ -z "$(git status --porcelain)" ]; then
    echo -e "Repo Status: ${GREEN}Working tree is clean.${RESET}\n"
  else
    echo -e "${RED}There are uncommitted files.${RESET} Type ${YELLOW}y|Y|yes${RESET} to fix."
    ./ops/sh/app.sh 3
  fi
}

#---------------------------------------#
# init                                  #
#---------------------------------------#
# function to create a git repo locally
git_repo_create() {
	read -p $'\nDo you want to create a git repo? (yes|no): ' repo_init
	case "$repo_init" in
		yes|Y|y)
			if [ -d .git ]; then
				echo -e "${RED}Current directory already initialised ${RESET}\n"
			else
				echo -e "${GREEN}Please enter initial commit message: ${RESET}\n"
				read -r commitMsg
				git init && git add . && git commit -m "$commitMsg"

        # Initialize Git repo
        git init
        git branch -M develop

        # Develop branch
        echo "Creating files in develop branch"
        mkdir src
        touch README.md
        echo "Please delete before first commit. Thank you!" >> src/info.txt
        git add .
        read -p "Enter develop commit message: " cm_develop
        git commit -m "$cm_develop"

        # Main branch
        git branch main
        git checkout main
        echo "Creating files in main branch" 
        mkdir docs
        touch dclm-app .gitignore Makefile
        git add .
        read -p "Enter main commit message: " cm_main  
        git commit -m "$cm_main"

        # bams branch 
        git checkout -b bams
        echo "Creating files in bams-dev branch"
        mkdir -p .github/workflows docs ops
        mkdir -p ops/{docker,mk,nginx,php,sh}
        touch ops/.gitignore ops/Makefile
        touch .github/deploy.yml
        git add .
        read -p "Enter commit message: " cm_bamsdev
        git commit -m "$cm_bamsdev"

        # release/dev branch
        git checkout -b release/dev 
        echo "Committing in release/dev branch"
        git add .
        read -p "Enter commit message: " cm_dclmdev
        git commit -m "$cm_dclmdev"

        # release/prod branch
        git checkout -b release/prod
        echo "Committing in release/prod branch" 
        git add .
        read -p "Enter commit message: " cm_dclmprod
        git commit -m "$cm_dclmprod"

			fi
			;;
		no|N|n)
			echo -e "${GREEN}Alright. Thank you...${RESET}"
			;;
		*) \
			echo -e "${GREEN}No choice. Exiting script...${RESET}"
			;;
	esac
}

# function to create a repository on GitHub
gh_repo_create() {
	read -p $'\nDo you want to create a github repo? (yes|no): ' repo_name
	case "$repo_name" in
		yes|Y|y)
			read -p "Enter GitHub username: " ghUser
			read -p "Enter GitHub repo name: " ghName
      gh="$ghUser/$ghName"
			result="$(gh_repo_check $gh)"
			if [ $result -eq 200 ]; then
				echo -e "${RED}GitHub repo exists. I stop here. ${RESET}\n"
			else
				echo -e "\nWhich type of repository are you creating?:"
				echo "1. Private repo"
				echo "2. Public repo"
				read -p "Enter a number to select your choice: " repoType
				if [ $repoType -eq 1 ]; then
					REPO=private
				elif [ $repoType -eq 2 ]; then
					REPO=public
				else
					echo "Invalid choice"
					exit 0
				fi
				gh repo create ${ghUser}/${ghName} --$REPO --source=. --remote=origin
			fi
			;;
		no|N|n)
			echo -e "${GREEN}Okay, thank you...${RESET}"
			;;
		*)
			echo -e "${GREEN} No choice. Exiting script...${RESET}"
			;;
	esac
}

#---------------------------------------#
# app                                   #
#---------------------------------------#
# function to commit git repository
git_commit() {
  # function to commit repo with untracked files
  git_commit_new() {
    read -p $'\nDo you want to commit repo files? (yes|no): ' git_commit
    case "$git_commit" in
      yes|Y|y)
        echo -e "\n${RED}Untracked files found and listed below: ${RESET}"
        git status -s
        echo -e $'\n'"${GREEN}Please enter commit message${RESET}: \c"
        read msg
        git add -A
        git commit -m "$msg"
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        ;;
    esac
  }

  # function to commit repo with modified files
  git_commit_old() {
    read -p $'\nDo you want to commit repo files? (yes|no): ' git_commit
    case "$git_commit" in
      yes|Y|y)
        echo -e "\n${RED}Modified files found and listed below: ${RESET}"
        git status -s
        echo -e $'\n'"${GREEN}Please enter commit message${RESET}: \c"
        read msg
        git commit -am "$msg"
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        ;;
    esac
  }

  if git status --porcelain | grep -q "^??"; then
    git_commit_new
  elif git status --porcelain | grep -qE '[^ADMR]'; then
    git_commit_old
  elif [ -z "$(git status --porcelain)" ]; then
    echo -e "${RED} Nothing to commit, thanks...${RESET}\n"
  else
    echo -e "${RED} Unknown status. Aborting...${RESET}\n"
    exit 1
  fi
}

docker_build() {
  # function to purge docker images
  dkr_purge_image() {
    read -p $'\nDo you want to purge images? (yes|no): ' dkr_purge
    case "$dkr_purge" in
      yes|Y|y)
        if [ "$(docker images -qf "dangling=true")" ]; then
          echo -e "${RED}Removing dangling images...${RESET}"
          docker image prune -f
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        ;;
    esac
  }

  # function to delete docker image
  dkr_rmi_image() {
    read -p $'\nDo you want to remove image? (yes|no): ' dkr_rmi
    case "$dkr_rmi" in
      yes|Y|y)
        if docker image inspect $DL_DK_IMAGE &> /dev/null; then \
          echo -e "${RED}Deleting existing image...${RESET}"; \
          docker rmi $DL_DK_IMAGE; \
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        ;;
    esac
  }

  # function to build docker image
  dkr_build_image() {
    read -p $'\nDo you want to build image? (yes|no): ' dkr_build
    case "$dkr_build" in
      yes|Y|y)
        if grep -q "^NODE_ENV=" "$dotenv"; then
          echo -e "Building ${GREEN}$DL_APP_NAME:$DL_HOST_ENV${RESET} image with NODE_ENV"
          echo -e "Value of NODE_ENV: $NODE_ENV"
          ln -s ops/docker/.dockerignore .dockerignore
          docker build --no-cache --build-arg NODE_ENV=$NODE_ENV -t $DL_DK_IMAGE -f $DL_APP_DK_FILE .
          if [ $? -eq 0 ]; then
            echo -e "\nDocker image ${GREEN}$DL_APP_NAME:$DL_HOST_ENV${RESET} built successfully\n"
            rm .dockerignore
            docker images | grep ${ORG_ID}/${DL_APP_NAME}
          else
            echo -e "Error setting secrets\n"
            exit 1
          fi
        else
          echo -e "${GREEN}Building $DL_DK_IMAGE image${RESET}"
          ln -s ops/docker/.dockerignore .dockerignore
          docker build -t $DL_DK_IMAGE -f $DL_APP_DK_FILE .
          if [ $? -eq 0 ]; then
            echo -e "\nDocker image ${GREEN}$DL_APP_NAME:$DL_HOST_ENV${RESET} built successfully\n"
            rm .dockerignore
            docker images | grep ${ORG_ID}/${DL_APP_NAME}
          else
            echo -e "Error setting secrets\n"
            exit 1
          fi
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        ;;
    esac
  }

  dkr_purge_image
  dkr_rmi_image
  dkr_build_image
}

#---------------------------------------#
# deploy                                #
#---------------------------------------#
git_push() {
  git_branch
  ga_workflow_env $DL_APP_ENV_FILE
  commit_status
  gh_secret_set
  git_repo_push
}

ga_workflow_env() {
  read -p $'\nDo you want to create workflow env? (yes|no): ' ga_workflow
  case "$ga_workflow" in
    yes|Y|y)
      # check if argument is provided
      if [ $# -ne 1 ]; then
        read -p $'\nEnvfile not found... Enter path to env file: ' env
        envfile="$env"
      else
        envfile="$1"
      fi

      vfile="./ops/vars.txt"
      ga_file1="deploy.yml"
      ga_file2="deploy_new.yml"
      ga_dir="./.github/workflows"
      ga="$ga_dir/$ga_file1"
      ga_new="$ga_dir/$ga_file2"

      # Delete vars.txt if it exists
      if [ -f $vfile ]; then
        rm $vfile
      fi

      # Read .env file
      IFS=' ' read -r -a exclude <<< "$DL_ENV_EXCLUDE"
      while IFS= read -r kv; do
        key=$(echo "$kv" | cut -d= -f1)
        if [[ " ${exclude[@]} " =~ " $key " ]]; then
          continue
        fi
        if [[ $key != "" && $key != "#"* ]]; then
          echo "$key" >> $vfile
        fi
      done < <(grep '=' $envfile)

      # Load variables from vars.txt
      while read -r var; do
        vars+=($var)
      done < $vfile

      # Find the "Generate envfile" step in deploy.yml
      envfile_line=$(grep -n "uses: SpicyPizza/create-envfile@v2.0" $ga | cut -d: -f1)
      envfile_line=$((envfile_line+1))
      tail_line=$(grep -n "directory: \${{ env.DL_ENV_SRC }}" $ga | cut -d: -f1)

      # Generate new file with variables
      {
        head -n $((envfile_line)) $ga
        for var in "${vars[@]}"; do
          echo "          envkey_$var: \${{ secrets.$var }}" 
        done
        tail -n +$((tail_line)) $ga
      } > $ga_new

      # Overwrite original 
      mv $ga_new $ga
      rm -f $vfile
      echo -e "${GREEN}Actions worklow updated successfully!${RESET}\n"
      ;;
    no|N|n)
      echo -e "${GREEN}Alright. Thank you...${RESET}\n"
      ;;
    *)
      echo -e "${GREEN}No choice. Exiting script...${RESET}"
      ;;
  esac
}

gh_secret_set() {
  # function to set secrets on private GitHub repo
  gh_secret_private() {
    read -p $'\nDo you want to set secrets on private repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        # check if argument is provided
        if [ $# -ne 1 ]; then
          read -p $'\nEnvfile not found... Enter path to env file: ' env
          envfile="$env"
        else
          envfile="$1"
        fi

        # Set number of retries and delay between retries  
        MAX_RETRIES=3
        RETRY_DELAY=2
        # Helper function to retry command on failure
        retry() {
          local retries=$1
          shift
          local count=0
          until "$@"; do
            exit=$?
            count=$(($count + 1))
            if [ $count -lt $retries ]; then
              echo "Command failed! Retrying in $RETRY_DELAY seconds..."
              sleep $RETRY_DELAY 
            else
              echo "Failed after $count retries."
              return $exit
            fi
          done 
          return 0
        }

        echo -e "${GREEN}Setting secrets...${RESET}\n"
        # Read the .env file and set the secrets
        retry $MAX_RETRIES gh secret set -f "$envfile"
        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Secrets set successfully\n"
        else
          echo -e "Error setting secrets\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to delete secrets on private GitHub repo
  gh_secret_private_rm() {
    read -p $'\nDo you want to delete secrets on private repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Deleting private repo secrets...${RESET}\n"
        # Get list of secrets 
        secrets=$(gh secret list --repo ${DL_GH_OWNER_REPO} --json name --jq '.[].name')

        # Read secrets into array
        SECRETS=()
        while IFS= read -r secret; do
          SECRETS+=("$secret") 
        done <<< "$secrets"

        # Delete secrets
        for secret in "${SECRETS[@]}"; do
          gh secret delete --repo ${DL_GH_OWNER_REPO} "$secret"
        done

        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Secrets deleted successfully\n"
        else
          echo -e "Error deleting secrets\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to set secrets on public GitHub repo
  gh_secret_public() {
    read -p $'\nDo you want to set secrets on public repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        # check if argument is provided
        if [ $# -ne 1 ]; then
          read -p $'\nEnvfile not found... Enter path to env file: ' env
          envfile="$env"
        else
          envfile="$1"
        fi

        # Set number of retries and delay between retries  
        MAX_RETRIES=3
        RETRY_DELAY=2
        # Helper function to retry command on failure
        retry() {
          local retries=$1
          shift
          local count=0
          until "$@"; do
            exit=$?
            count=$(($count + 1))
            if [ $count -lt $retries ]; then
              echo -e "Command failed! Retrying in $RETRY_DELAY seconds..."
              sleep $RETRY_DELAY 
            else
              echo -e "Failed after $count retries."
              return $exit
            fi
          done 
          return 0
        }

        echo -e "${GREEN}Setting secrets...${RESET}\n"
        # Check the DL_GH_BRANCH variable
        if [ "$DL_GH_BRANCH" = "release/prod" ]; then
          env="prod"
        elif [ "$DL_GH_BRANCH" = "release/dev" ]; then
          env="dev"
        else
          echo "DL_GH_BRANCH value not what is expected!"
          exit 0
        fi
        # Read the .env file and set the secrets
        retry $MAX_RETRIES gh secret set -f "$envfile" -e "$env"
        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Secrets set successfully\n"
        else
          echo -e "Error setting secrets\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to delete secrets on public GitHub repo
  gh_secret_public_rm() {
    read -p $'\nDo you want to delete secrets on public repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Deleting public repo secrets...${RESET}\n"
        # Check the DL_GH_BRANCH variable
        if [ "$DL_GH_BRANCH" = "release/prod" ]; then
          env="prod"
        elif [ "$DL_GH_BRANCH" = "release/dev" ]; then
          env="dev"
        else
          echo "Aha! No need then..."
          exit 0
        fi

        # Get list of secrets 
        secrets=$(gh secret list --repo ${DL_GH_OWNER_REPO} --env $env --json name --jq '.[].name')

        # Read secrets into array
        SECRETS=()
        while IFS= read -r secret; do
          SECRETS+=("$secret") 
        done <<< "$secrets"

        # Delete secrets
        for secret in "${SECRETS[@]}"; do
          gh secret delete --repo ${DL_GH_OWNER_REPO} --env $env "$secret"
        done

        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Secrets deleted successfully\n"
        else
          echo -e "Error deleting secrets\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to set variables on private GitHub repo
  gh_variable_private() {
    read -p $'\nDo you want to set variables on private repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Setting variables...${RESET}\n"
        vhost=${DL_NGX_VHOST}
        gh variable set DL_NGX_VHOST < "$vhost"
        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Variables set successfully\n"
        else
          echo -e "Error setting variables\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to delete variables on private GitHub repo
  gh_variable_private_rm() {
    read -p $'\nDo you want to delete variables on private repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Deleting variables...${RESET}\n"
        gh variable delete DL_NGX_VHOST --repo ${DL_GH_OWNER_REPO}

        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Variables deleted successfully\n"
        else
          echo -e "Error deleting variables\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to set variables on public GitHub repo
  gh_variable_public() {
    read -p $'\nDo you want to set variables on public repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Setting variables...${RESET}\n"
        # Check the DL_GH_BRANCH variable
        if [ "$DL_GH_BRANCH" = "release/prod" ]; then
          env="prod"
        elif [ "$DL_GH_BRANCH" = "release/dev" ]; then
          env="dev"
        else
          echo "Haa! No need then..."
          exit 0
        fi
        vhost=${DL_NGX_VHOST}
        gh variable set DL_NGX_VHOST < "$vhost" -e"$env"
        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Variables set successfully\n"
        else
          echo -e "Error setting variables\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  # function to delete variables on public GitHub repo
  gh_variable_public_rm() {
    read -p $'\nDo you want to delete variables on public repo? (yes|no): ' git_push
    case "$git_push" in
      yes|Y|y)
        echo -e "${GREEN}Deleting variables...${RESET}\n"
        # Check the DL_GH_BRANCH variable
        if [ "$DL_GH_BRANCH" = "release/prod" ]; then
          env="prod"
        elif [ "$DL_GH_BRANCH" = "release/dev" ]; then
          env="dev"
        else
          echo "Haa! No need then..."
          exit 0
        fi

        gh variable delete DL_NGX_VHOST --repo ${DL_GH_OWNER_REPO} --env $env

        # Check return code and output result
        if [ $? -eq 0 ]; then
          echo -e "Variables deleted successfully\n"
        else
          echo -e "Error deleting variables\n"
          exit 1
        fi
        ;;
      no|N|n)
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }

  check="$(gh_repo_view)"
  if [ "$check" == "private" ]; then
    gh_secret_private_rm
    gh_secret_private $DL_APP_ENV_FILE
    gh_variable_private_rm
    gh_variable_private
  elif [ "$check" == "public" ]; then
    gh_secret_public_rm
    gh_secret_public $DL_APP_ENV_FILE
    gh_variable_public_rm
    gh_variable_public
  else
    echo "Could not set secrets. Something is wrong!"
    exit 1
  fi
}

git_repo_push() {
  read -p $'\nDo you want to push your commit to GitHub? (yes|no): ' git_push
  case "$git_push" in
    yes|Y|y)
      echo -e "${GREEN}Pushing commit to GitHub...${RESET}\n"
      git push
      ;;
    no|N|n)
      echo -e "${GREEN}Alright. Thank you...${RESET}\n"
      ;;
    *)
      echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
      exit 1
      ;;
  esac
}

# function to push docker image
docker_push() {
  # which git branch?
  git_branch

	read -p $'\nDo you want to push docker image? (yes|no): ' dkr_push
	case "$dkr_push" in
		yes|Y|y)
			echo ${DL_DK_TOKEN} | docker login -u ${DL_DK_HUB} --password-stdin
	    docker push $DL_DK_IMAGE
			;;
		no|N|n)
			echo -e "${GREEN}Alright. Thank you...${RESET}"
			;;
		*)
			echo -e "${GREEN}No choice. Exiting script...${RESET}"
			;;
	esac
}

#---------------------------------------#
# github actions                        #
#---------------------------------------#
# function to create dns record on aws route53
create_dns_record() {
  # Run the AWS CLI command to list resource record sets
  record_sets=$(aws route53 list-resource-record-sets \
    --hosted-zone-id "$DL_AWS_R53_ZONE_ID" \
    --query "ResourceRecordSets[?Name == '$DL_APP_URL.']" \
    --output json)

  # Check if the record_sets variable is empty (DNS entry doesn't exist)
  if echo "$record_sets" | jq -e '.[].Name | test("'$DL_URL1'\\.'$DL_URL2'\\.'$DL_URL3'")' > /dev/null; then
    echo "DNS entry $DL_APP_URL exists."
    exit 0
  else
    echo "Creating DNS entry for $DL_APP_URL..."
    touch route53.json
  cat >route53.json <<EOF
  {
    "Comment": "CREATE record ",
    "Changes": [{
    "Action": "CREATE",
      "ResourceRecordSet": {
        "Name": "$DL_APP_URL",
        "Type": "A",
        "TTL": 300,
        "ResourceRecords": [{ "Value": "$DL_HOST_PUBLIC_IP"}]
    }}]
  }
EOF
    cat route53.json
    aws route53 change-resource-record-sets --hosted-zone-id "$DL_AWS_R53_ZONE_ID" --change-batch file://route53.json
  fi
}

# function to create directory to deploy app  
create_app_dir() {
  # Navigate into the docker directory
  cd "$DL_APP_DK_DIR"

  # Check if target folder exists
  if [ ! -d "$DL_APP_NAME" ]; then
    # Folder doesn't exist, create it
    echo "Creating folder $DL_APP_NAME"  
    mkdir -p "$DL_APP_NAME"
  else
    # Folder exists, print message
    echo "Folder $DL_APP_NAME already exists"
  fi
}

# function to clone app repository 
clone_app_repo() {
  # Check app dir
  echo -e "\nChecking if app directory exists.."
  if [ ! -d "$DL_APP_DIR" ]; then
    echo "Directory not found, creating..."
    mkdir -p "$DL_APP_DIR"
  else
    echo "Directory already exists."
  fi

  # Enter into app dir
  echo -e "\nEntering app directory.."
  cd "$DL_APP_DIR"

  # Clone app repo
  echo -e "\nCloning latest repo changes.."
  if [ ! -d .git ]; then
    echo "App repo not found. Cloning..."
    git clone "$DL_GH_REPO" . \
    && git switch "$DL_GH_BRANCH"
  else
    echo "App repo exists..."
    git fetch --all \
    && git switch "$DL_GH_BRANCH"
  fi
}

# function to create nginx vhost for app url
create_nginx_vhost() {
  # enter directory
  cd "$DL_ENV_DEST"

  # another way
  ngxx="vhost.conf"
  ngx=$(cat "$ngxx")
  eval "VHOST=\"$ngx\""

  # Create a temporary file with the provided configuration
  echo -e "\nCreating temporary file..."
  temp_file="$(mktemp)"
  echo "$VHOST" > "$temp_file"

  # Extract the block identifier (the first line of the provided config)
  echo -e "\nExtracting the vhost block identifier..."
  block_identifier=$(head -n 1 "$temp_file")
  echo -e "Content of block identifier:\n$block_identifier"

  # Check if the vhost configuration exists
  echo -e "\nChecking if vhost config exists..."
  if grep -qF "$block_identifier" "$DL_HOST_NGX_DIR/$DL_NGX_CONF"; then
    echo -e "Vhost config already exists."

    # Get the existing vhost block that matches the block identifier
    echo -e "\nExtracting existing vhost config..."
    end_pattern="^}"
    existing_block="$(sed -n "/$block_identifier/,/$end_pattern/p" "$DL_HOST_NGX_DIR/$DL_NGX_CONF")"
    echo -e "Content of existing vhost:\n$existing_block"

    # Compare the existing block with the provided configuration
    echo -e "\nComparing existing vhost config with provided vhost config..."
    if diff -q <(echo "$VHOST") <(echo "$existing_block"); then
      echo "Configuration matches. No action needed."
    else
      # Delete the existing vhost configuration and append the provided config
      echo -e "\nDeleting existing vhost config..."
      sed -i "/$block_identifier/,/$end_pattern/d" "$DL_HOST_NGX_DIR/$DL_NGX_CONF"
      echo -e "\nUpdating vhost config..."
      echo -e "\n$VHOST" | sudo tee -a "$DL_HOST_NGX_DIR/$DL_NGX_CONF"
      echo "Nginx vhost configuration updated."

      # Test Nginx configuration for syntax errors
      sudo nginx -t

      # Reload Nginx if the configuration is valid
      if [ $? -eq 0 ]; then
        sudo nginx -s reload
        sudo systemctl status nginx
      else
        echo "Nginx configuration is invalid. Not reloading Nginx."
      fi
    fi
  else
    echo "Nginx vhost configuration not found."
    echo "Creating Nginx vhost entry for $DL_APP_URL..."
    echo -e "\n$VHOST" | sudo tee -a "$DL_HOST_NGX_DIR/$DL_NGX_CONF"

    # Test Nginx configuration for syntax errors
    sudo nginx -t

    # Reload Nginx if the configuration is valid
    if [ $? -eq 0 ]; then
      sudo nginx -s reload
      sudo systemctl status nginx
    else
      echo "Nginx configuration is invalid. Not reloading Nginx."
    fi  
  fi

  # Remove temporary files
  echo -e "\nRemoving temporary files..."
  rm -f "$temp_file"
  rm -f "$ngxx"
}

# function to deploy app
ga_deploy_app() {
  # Enter app dir
  echo -e "\nEntering app directory..."
  cd "$DL_APP_DIR"

  # Pull repo changes
  echo -e "\nDownloading latest repo changes..."
  make new

  # Drop running container
  echo -e "\nDropping running container..."
  make down

  # Start new container
  echo -e "\nLaunching latest app version..."
  make run
}

#---------------------------------------#
# utils                                 #
#---------------------------------------#
# function to copy .env based on environment
copy_app_env() {
  # Define the source and destination directories
  src_dir="./ops"
  dest_dir="./src"

  # Define environment file
  dest_env=".env"
  default_env_file="bams.env"

  # Display the options
  echo "Please select an environment:"
  echo "1) dclm-dev"
  echo "2) dclm-prod"
  echo "3) Custom env"

  # Read the user's selection
  read -p "Select an option or press enter to copy default: " selection

  # Handle the user's selection
  case $selection in
    1)
      env_file="dclm-dev.env"
      ;;
    2)
      env_file="dclm-prod.env"
      ;;
    3)
      read -p "Enter the name of the custom environment file: " env_file
      ;;
    "")
      env_file=$default_env_file
      ;;
    *)
      echo -e "Invalid option. Please select 1, 2, or 3\n"
      ;;
  esac

  # Copy the environment file
  cp "${src_dir}/${env_file}" "${dest_dir}/${dest_env}"

  # Check if the copy was successful
  if [ $? -eq 0 ]; then
    echo -e "Environment file copied successfully.\n"
  else
    echo -e "Failed to copy environment file. Exiting.\n"
    exit 1
  fi
}

# function to scan GitHub repo
git_repo_scan() {
	read -p $'\nDo you want to scan this repo? (yes|no): ' repo_scan
	case "$$repo_scan" in
		yes|Y|y)
			echo -e "${GREEN}Scanning repo for secrets...${RESET}\n"
			ggshield secret scan repo .
			;;
		no|N|n)
			echo -e "${GREEN}Okay. Thank you...${RESET}\n"
			exit 0
			;;
		*)
			echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
			exit 1
			;;
	esac  
}

#function to rename local git repo
git_repo_rename() {
  echo -e "I love JESUS"
}

# function to rename GitHub repo
gh_repo_rename() {
  read -p "Enter GitHub username: " gh_user

  repo_name() {
    read -p "Enter current repository name: " gh_repo
    read -p "Enter new repository name: " new_name
    # API to rename repo
    API_ENDPOINT="https://api.github.com/repos/${gh_user}/${gh_repo}"

    # Make API call to rename repo
    curl \
      -X PATCH \
      -H "Authorization: token ${DL_GH_TOKEN}" \
      -d '{"name":"'"${new_name}"'"}' \
      ${API_ENDPOINT}

    if [ $? -eq 0 ]; then
      echo -e "Repository renamed successfully!\n"
    else
      echo -e "Error renaming repository\n" >&2
      exit 1
    fi

    # run function to change repo remote url
    repo_url
  }

  repo_url() {
    read -p $'\nAbout to change repo"s remote url. Proceed? (yes|no): ' user_grant
    case "$user_grant" in
      yes|Y|y)
        read -p "Enter new repository name: " NEW_NAME
        git remote set-url origin git@github.com:${GH_USER}/${NEW_NAME}.git
        git remote -v
        if [ $? -eq 0 ]; then
          echo "Remote url successfully set!"
        else
          echo "Error renaming repository" >&2
          exit 1
        fi
        ;; 
      no|N|n) 
        echo -e "${GREEN}Alright. Thank you...${RESET}\n"
        exit 0
        ;;
      *)
        echo -e "${GREEN}No choice. Exiting script...${RESET}\n"
        exit 1
        ;;
    esac
  }
  # Select action
  echo "Select action:"
  echo "1) Rename repo name on Github"
  echo "2) Rename repo remote url"
  read action_selection
  if [ $action_selection -eq 1 ]; then
    repo_name
  elif [ $action_selection -eq 2 ]; then
    repo_url
  else
    echo "Invalid selection"
    exit 1  
  fi
}

# function to check if GitHub repo exists
gh_repo_check() {
  # check if argument is provided
  if [ $# -ne 1 ]; then
    read -p "Enter GitHub username: " ghUser
		read -p "Enter GitHub repo name: " ghName
    repo="${ghUser}/${ghName}"
  else
    repo=$1
  fi

  status_code=$(curl -s -o /dev/null -w "%{http_code}" -H "Authorization: token ${DL_GH_TOKEN}" "https://api.github.com/repos/$repo")

  code1=200
  code2=404

  if [ $status_code -eq 200 ]; then
    echo $code1
  elif [ $status_code -eq 404 ]; then
    echo $code2
  else
    echo "Status code: $status_code" >&2
    exit 1
  fi
}

# function to check if GitHub repo is private/public
gh_repo_view() {
  code1=private
  code2=public
  view=$(gh repo view $DL_GH_OWNER_REPO --json isPrivate -q .isPrivate 2>/dev/null)
	if [ "$view" = "true" ]; then
		echo $code1
	else
		echo $code2
	fi
}


# Check if a choice was provided as a command line argument
if [ $# -eq 0 ]; then
  # If no choice was provided, prompt for action
  echo "1) Create local repo"
  echo "2) Create GitHub repo"
  echo "3) Commit git repo"
  echo "4) Build docker image" 
  echo "5) Push git repo"
  echo "6) Push docker image"
  echo "7) Create DNS record"
  echo "8) Create app directory"
  echo "9) Clone app repo"
  echo "10) Create Nginx vhost"
  echo "11) Deploy app to server"
  echo "----------------------------------"
  read -p $'\nSelect action to perform [1-9]: ' choice
else
  # If an argument is provided, use it
  choice="$1"
fi

if [ $choice -eq 0 ]; then
  nginx_config
elif [ $choice -eq 1 ]; then
  git_repo_create
elif [ $choice -eq 2 ]; then
  gh_repo_create
elif [ $choice -eq 3 ]; then
  git_commit
elif [ $choice -eq 4 ]; then
  docker_build
elif [ $choice -eq 5 ]; then
  git_push
elif [ $choice -eq 6 ]; then
  docker_push
elif [ $choice -eq 7 ]; then
  create_dns_record
elif [ $choice -eq 8 ]; then
  create_app_dir
elif [ $choice -eq 9 ]; then
  clone_app_repo
elif [ $choice -eq 10 ]; then
  create_nginx_vhost
elif [ $choice -eq 11 ]; then
  ga_deploy_app
elif [ $choice -eq 12 ]; then
  copy_app_env
elif [ $choice -eq 13 ]; then
  git_repo_scan
elif [ $choice -eq 14 ]; then
  git_repo_rename
elif [ $choice -eq 15 ]; then
  gh_repo_rename
elif [ $choice -eq 16 ]; then
  gh_repo_check
elif [ $choice -eq 17 ]; then
  gh_repo_view
else
  echo "Invalid selection"
  exit 1  
fi

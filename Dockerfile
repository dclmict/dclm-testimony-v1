FROM richarvey/nginx-php-fpm

#ARG appDir=/usr/src/app
ARG gitBranch=progress-bar

# ------------------------------------------------------------------------------
# Install and Build the application
# ------------------------------------------------------------------------------

# Set the current directory
#WORKDIR $appDir

# Clone the application
RUN git checkout $gitBranch

# Clone the application
# RUN git clone https://github.cfpb.gov/ConsumerResponse/explorer-app.git $appDir && \
#     git checkout $gitBranch

CMD ["/docker-entrypoint.sh"]
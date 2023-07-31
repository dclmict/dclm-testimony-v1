FROM opeoniye/php82:latest

# set working directory
WORKDIR /var/www

# add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# copy code
COPY --chown=www:www-data ./src /var/www
COPY ./ops/docker /var/docker

# set permissions for laravel app
RUN chmod -R ug+w /var/www/storage

# copy configs
COPY ./ops/docker/run.sh /var/docker/run.sh
COPY ./ops/docker/supervisor.conf /etc/supervisord.conf
COPY ./ops/docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY ./ops/docker/php/fpm.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./ops/docker/ngx/nginx.conf /etc/nginx/nginx.conf
COPY ./ops/docker/ngx/testify.conf /etc/nginx/sites-enabled/default
COPY ./ops/docker/ngx/ssl.conf /etc/nginx/ssl.conf
COPY ./ops/docker/ngx/proxy /etc/nginx/proxy_params
COPY ./ops/docker/ngx/exploit.conf /etc/nginx/snippets/exploit_protection.conf
COPY ./ops/docker/ngx/optimize.conf /etc/nginx/snippets/site_optimization.conf
COPY ./ops/docker/ngx/log.conf /etc/nginx/snippets/logging.conf

## deployment
RUN chmod +x /var/docker/run.sh

EXPOSE 89
ENTRYPOINT ["/var/docker/run.sh"]
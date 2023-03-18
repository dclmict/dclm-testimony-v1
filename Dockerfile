FROM opeoniye/dclm-php82-base:latest

# set working director
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
COPY ./ops/docker/supervisor.conf /etc/supervisord.conf
COPY ./ops/docker/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY ./ops/docker/ngx/nginx.conf /etc/nginx/nginx.conf
COPY ./ops/docker/ngx/testify.conf /etc/nginx/sites-enabled/default
COPY ./ops/docker/ngx/ssl.conf /etc/nginx/ssl.conf
COPY ./ops/docker/ngx/proxy /etc/nginx/proxy_params
COPY ./ops/docker/ngx/exploit.conf /etc/nginx/snippets/exploit_protection.conf
COPY ./ops/docker/ngx/optimize.conf /etc/nginx/snippets/site_optimization.conf
COPY ./ops/docker/ngx/log.conf /etc/nginx/snippets/logging.conf

# php log files
RUN mkdir /var/log/php && \
  touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

## deployment
RUN composer install --optimize-autoloader --no-dev && \
  chown -R www:www-data /var/www && \
  rm -rf /var/www/html && \
  # give scripts execute permissions
  chmod +x /var/docker/run.sh

EXPOSE 80
ENTRYPOINT ["/var/docker/run.sh"]
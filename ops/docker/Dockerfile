FROM opeoniye/php82:latest

# set working directory
WORKDIR /var/www

# copy code
COPY --chown=www-data:www-data ./src /var/www

# set permissions for laravel app
RUN chmod -R ug+w /var/www/storage

# php config
COPY ./ops/php/php.ini /usr/local/etc/php/conf.d/app.ini
COPY ./ops/php/fpm.conf /usr/local/etc/php-fpm.d/www.conf

# nginx config
COPY ./ops/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./ops/nginx/testimony.conf /etc/nginx/sites-enabled/default
COPY ./ops/nginx/ssl.conf /etc/nginx/ssl.conf
COPY ./ops/nginx/proxy /etc/nginx/proxy_params
COPY ./ops/nginx/exploit.conf /etc/nginx/snippets/exploit_protection.conf
COPY ./ops/nginx/optimize.conf /etc/nginx/snippets/site_optimization.conf
COPY ./ops/nginx/log.conf /etc/nginx/snippets/logging.conf

# scripts
COPY ./ops/sh/run.sh /var/docker/run.sh

# supervisor
COPY ./ops/docker/supervisor.conf /etc/supervisord.conf

## deployment
RUN composer update
RUN composer install --optimize-autoloader --no-dev
RUN chmod +x /var/docker/run.sh

# set proper permissions
RUN cd /var/www && \
chown -R www-data:www-data . && \
find . -type d -exec chmod 2775 {} \; && \
find . -type f -exec chmod 0664 {} \; && \
rm -rf /var/www/html

ENTRYPOINT ["/var/docker/run.sh"]

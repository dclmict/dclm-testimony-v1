FROM nginx:1.21

RUN apt-get update && apt-get install -y \
        openssl \
    && openssl dhparam -out /etc/ssl/certs/dhparam.pem 2048

COPY ./nginx.conf /etc/nginx/nginx.conf
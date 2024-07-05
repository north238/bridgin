FROM nginx:stable-alpine

COPY . .
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

RUN adduser -g laravel -s /bin/sh -D laravel

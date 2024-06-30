FROM nginx:stable-alpine

ENV NGINXUSER=laravel
ENV NGINXGROUP=laravel

COPY . ./

COPY default.conf /etc/nginx/conf.d/default.conf

RUN sed -i "s/user www-data/user laravel/g" /etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}

FROM webdevops/php-nginx:8.3-alpine

ENV WEB_DOCUMENT_ROOT=/app/public
ENV PHP_DATE_TIMEZONE="Asia/Tehran"

#COPY ./docker/config /opt/docker

WORKDIR /app

COPY --chown=application:application ./app .

RUN chown -R application:application .

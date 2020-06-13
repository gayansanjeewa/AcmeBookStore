FROM nginx:alpine

RUN apk add --no-cache bash

RUN rm -rf /var/cache/apk/*

COPY app.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
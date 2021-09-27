FROM oanhnn/laravel-echo-server:latest
RUN mkdir -p /etc/nginx/certs/mkcert
ADD ./nginx/certs/ /etc/nginx/certs/mkcert
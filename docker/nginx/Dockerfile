ARG BASE_IMAGE=app-base:latest
FROM ${BASE_IMAGE}

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && apt-get install -y --no-install-recommends \
    gnupg2 libcap2-bin openssl \
 && rm -rf /var/lib/apt/lists/*

RUN curl -fsSL https://nginx.org/keys/nginx_signing.key | gpg --dearmor -o /usr/share/keyrings/nginx-archive-keyring.gpg \
 && echo "deb [signed-by=/usr/share/keyrings/nginx-archive-keyring.gpg] http://nginx.org/packages/ubuntu noble nginx" \
    > /etc/apt/sources.list.d/nginx.list \
 && apt-get update && apt-get install -y --no-install-recommends nginx=1.28.* \
 && rm -rf /var/lib/apt/lists/*

RUN setcap 'cap_net_bind_service=+ep' /usr/sbin/nginx

RUN set -eux; \
    mkdir -p /etc/nginx/ssl; \
    openssl req -x509 -nodes -days 3650 -newkey rsa:2048 \
      -keyout /etc/nginx/ssl/selfsigned.key \
      -out /etc/nginx/ssl/selfsigned.crt \
      -subj "/C=UA/ST=Kyiv/L=Kyiv/O=Local Dev/OU=Dev/CN=localhost"; \
    chmod 0600 /etc/nginx/ssl/selfsigned.key; \
    chmod 0644 /etc/nginx/ssl/selfsigned.crt

COPY nginx.conf /etc/nginx/nginx.conf

RUN set -eux; \
    mkdir -p /etc/nginx/conf.d /var/cache/nginx /var/run/nginx /var/log/nginx; \
    chown -R app_user:app /etc/nginx/conf.d /var/cache/nginx /var/run/nginx /var/log/nginx /etc/nginx/ssl; \
    chmod 0775 /var/log/nginx

WORKDIR /app
EXPOSE 80 443

USER app_user
CMD ["nginx", "-g", "daemon off;"]

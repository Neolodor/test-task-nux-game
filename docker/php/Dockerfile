ARG BASE_IMAGE=app-base:latest
FROM ${BASE_IMAGE}

ARG DEBIAN_FRONTEND=noninteractive

RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
      software-properties-common ca-certificates curl gnupg2 \
      git unzip gosu \
    ; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    add-apt-repository ppa:ondrej/php -y; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
      php8.4-cli php8.4-fpm php8.4-common php8.4-pgsql php8.4-pdo php8.4-mbstring php8.4-xml \
      php8.4-curl php8.4-zip php8.4-intl php8.4-gd php8.4-bcmath php8.4-soap php8.4-opcache php8.4-readline \
    php8.4-redis \
    ; \
    rm -rf /var/lib/apt/lists/*

RUN set -eux; \
    curl -fsSL https://getcomposer.org/installer | php -- \
      --install-dir=/usr/local/bin --filename=composer; \
    composer --version

RUN set -eux; \
    mkdir -p /var/log/php; \
    touch /var/log/php/php8.4-fpm.log; \
    chown -R app_user:app /var/log/php; \
    chmod 0775 /var/log/php; \
    chmod 0664 /var/log/php/php8.4-fpm.log; \
    FPM_CONF="/etc/php/8.4/fpm/php-fpm.conf"; \
    if grep -Eq '^[[:space:]]*;?[[:space:]]*error_log[[:space:]]*=' "$FPM_CONF"; then \
      sed -ri 's~^[[:space:]]*;?[[:space:]]*error_log[[:space:]]*=.*$~error_log = /var/log/php/php8.4-fpm.log~' "$FPM_CONF"; \
    else \
      awk 'BEGIN{done=0} {print} /^\[global\]/{if(!done){print "error_log = /var/log/php/php8.4-fpm.log"; done=1}}' \
        "$FPM_CONF" > /tmp/php-fpm.conf && mv /tmp/php-fpm.conf "$FPM_CONF"; \
    fi

COPY www.conf /etc/php/8.4/fpm/pool.d/www.conf

RUN set -eux; \
    mkdir -p /var/lib/php/sessions; \
    chown -R app_user:app /var/lib/php/sessions /var/log/php; \
    chmod 0775 /var/lib/php/sessions /var/log/php

COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /app

USER root
CMD ["/usr/local/bin/entrypoint.sh"]

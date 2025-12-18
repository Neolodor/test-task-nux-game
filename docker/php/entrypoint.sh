#!/usr/bin/env bash
set -euo pipefail

mkdir -p /run/php
chown -R app_user:app /run/php
chmod 0775 /run/php

exec gosu app_user php-fpm8.4 -F -O -R -y /etc/php/8.4/fpm/php-fpm.conf

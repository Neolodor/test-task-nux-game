FROM ubuntu:24.04

ARG DEBIAN_FRONTEND=noninteractive
ARG APP_USER=app_user
ARG APP_GROUP=app
ARG APP_UID=2000
ARG APP_GID=2000

RUN apt-get update && apt-get install -y --no-install-recommends \
    ca-certificates \
    curl \
    gnupg2 \
    sudo \
    tzdata \
    wget \
    less \
    vim \
    nano \
    iputils-ping \
    net-tools \
    procps \
    lsof \
    strace \
    unzip \
 && rm -rf /var/lib/apt/lists/*

RUN ln -snf /usr/share/zoneinfo/UTC /etc/localtime && echo "UTC" > /etc/timezone

RUN set -eux; \
    groupadd -g "${APP_GID}" "${APP_GROUP}"; \
    useradd -m -u "${APP_UID}" -g "${APP_GID}" -s /bin/bash "${APP_USER}"; \
    echo "${APP_USER} ALL=(ALL) NOPASSWD:ALL" > "/etc/sudoers.d/${APP_USER}"; \
    chmod 0440 "/etc/sudoers.d/${APP_USER}"

ENV TZ=UTC

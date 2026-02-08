FROM php:8.3-fpm

ARG USER_ID=1000
ARG GROUP_ID=1000
ENV APP_HOME=/var/www/html
ARG INSIDE_DOCKER_CONTAINER=1
ENV INSIDE_DOCKER_CONTAINER=$INSIDE_DOCKER_CONTAINER
ENV PHP_MEMORY_LIMIT=512M

# 🔧 Dépendances système
RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    bash-completion \
    fish \
    procps \
    nano \
    git \
    unzip \
    libicu-dev \
    zlib1g-dev \
    libxml2 \
    libxml2-dev \
    libreadline-dev \
    supervisor \
    cron \
    sudo \
    libzip-dev \
    wget \
    librabbitmq-dev \
    libpq-dev \
    graphviz \
    ca-certificates \
 && pecl install amqp \
 && docker-php-ext-configure intl \
 && docker-php-ext-install sockets intl opcache zip pdo pdo_mysql pdo_pgsql pgsql \
 && docker-php-ext-enable amqp \
 && rm -rf /tmp/* /var/lib/apt/lists/* \
 && apt-get clean

# 🧰 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# 🔑 Dossier global Composer + PATH pour tous
ENV COMPOSER_HOME=/composer
ENV PATH="/composer/vendor/bin:${PATH}"

# 📦 Installer l'installer Laravel globalement (en root)
RUN composer global require laravel/installer

# 🐞 Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# 🛠️ php.ini
COPY ./php.ini /usr/local/etc/php/conf.d/custom.ini

# 👤 Utilisateur applicatif
RUN groupadd -g ${GROUP_ID} devuser \
 && useradd -r -u ${USER_ID} -g devuser devuser \
 && chown -R devuser:devuser /composer

# 🔁 Basculer vers devuser
USER devuser

# 📁 Dossier de travail
WORKDIR ${APP_HOME}

# ✅ Test (optionnel, pendant le build)
RUN laravel --version

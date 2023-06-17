FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev\
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl
RUN docker-php-ext-install pdo pdo_pgsql pgsql zip exif pcntl
RUN pecl install xdebug-3.2.0 && docker-php-ext-enable xdebug
RUN docker-php-ext-install gd

# Get latest Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user


RUN chown -R user:user /var/www/html
RUN chmod 755 /var/www/html

# Set working directory
WORKDIR /var/www/html

USER $user

CMD php artisan serve --host=0.0.0.0 --port=9000
EXPOSE 9000



FROM php:8.3-fpm

ENV PORT=8080


RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    ffmpeg \
    software-properties-common \
    supervisor \
    procps \
    vim \
    linux-headers-generic \
    && apt-get clean

    
# 安装 PHP 扩展
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd pdo pdo_mysql zip pcntl


# 安裝 Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 設置工作目錄
WORKDIR /var/www

# 刪除 www 目錄的默認內容
RUN rm -rf /var/www/html

# 複製項目文件
COPY . .

# 設置文件權限
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

EXPOSE ${PORT}


CMD ["php artisan serve --host=0.0.0.0 --port=${PORT}"]
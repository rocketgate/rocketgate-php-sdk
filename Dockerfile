FROM php:7.2-cli

RUN mkdir -p /var/client/
WORKDIR /var/client/

# Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/bin/ --filename=composer\
    && php -r "unlink('composer-setup.php');"

# Required packages
RUN apt-get update\
    && apt-get install git libzip-dev -y

# Install PHP xdebug
RUN pecl install zip\
    && docker-php-ext-enable zip

# Error log
RUN echo "error_log = /var/log/php_errors.log" >> $PHP_INI_DIR/php.ini \\
    && touch /var/log/php_errors.log

# Run tail to keep tty available
CMD ["tail", "-f", "/var/log/php_errors.log"]
FROM swaye/php-7.4-apache

# Copy project to prebuild
COPY . /var/www/html

# install app dependancies
#RUN composer install

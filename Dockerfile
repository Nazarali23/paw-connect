FROM php:8.2-apache

RUN a2enmod rewrite

COPY . /var/www/html/

# Apache root pages dizini olacak
RUN echo "DirectoryIndex index.php" >> /etc/apache2/apache2.conf
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/pages|' /etc/apache2/sites-available/000-default.conf

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

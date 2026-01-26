FROM php:8.2-apache
RUN a2enmod rewrite

# Projeyi Apache root'a kopyala
COPY . /var/www/html/

# DocumentRoot'u pages yap
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/pages|' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|<Directory /var/www/html>|<Directory /var/www/html/pages>|' /etc/apache2/apache2.conf

RUN chown -R www-data:www-data /var/www/html
EXPOSE 80

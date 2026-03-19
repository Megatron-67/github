# 1. Use an official PHP image with Apache
FROM php:8.2-apache

# 2. Install SQLite3 drivers
RUN apt-get update && apt-get install -y libsqlite3-dev && \
    docker-php-ext-install pdo pdo_sqlite

# 3. Copy your project files into the web directory
COPY . /var/www/html/

# 4. Give Apache permission to write to the database
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# 5. Set the port (Render uses $PORT)
ENV PORT=80
EXPOSE 80

# 6. Start Apache
CMD ["apache2-foreground"]

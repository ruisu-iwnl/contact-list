# Use the official Laravel Sail PHP image
FROM sail-8.3/app

# Copy application files
COPY . /var/www/html

# Set permissions
RUN sudo chown -R www-data:www-data storage

# Switch back to the root user
USER root

# Clear cache and optimize autoloader
RUN composer install --optimize-autoloader --no-dev

# Switch back to the www-data user
USER www-data

# Expose port 80
EXPOSE 80

# Start Laravel application
CMD php artisan serve --host=0.0.0.0 --port=80

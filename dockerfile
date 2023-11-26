# Start from a PHP image that matches your version requirement
FROM php:8.1-apache

# Install mysqli
RUN docker-php-ext-install mysqli

# Other setup (copying files, setting permissions, etc.)
# COPY . /var/www/html/
# ...

# Expose port and set the entry point if necessary
EXPOSE 80
# ENTRYPOINT [ "your-entrypoint.sh" ]

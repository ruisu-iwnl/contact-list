REDIS:
# Setting up Redis
sudo apt install redis-server
sudo nano /etc/redis/redis.conf (change config)
# Start Redis
sudo service redis-server start
# Check Redis status
sudo systemctl status redis-server.service
# Installs Redis in the app
composer require predis/predis

MYSQL:
# To access MySQL via Docker
docker-compose exec mysql mysql -u root -p
docker-compose exec mysql mysql -u admin -p

# Access MySQL in Docker container
docker exec -it 80a0645ca120 mysql -u root -p

UBUNTU WSL2:
# To install PHP in WSL2
sudo apt update
sudo apt update && sudo apt upgrade -y
sudo apt -y install software-properties-common
sudo add-apt-repository ppa:ondrej/php
sudo apt update

# If you need curl extension:
sudo apt install php-curl

# Restart Apache
sudo service apache2 restart

# If no zip/unzip extensions are found
sudo apt update && \
sudo apt install php-zip unzip php-xml && \
composer create-project --prefer-dist laravel/laravel contact-list

LARAVEL:
# Install MySQL and extension
sudo apt install mysql-server
sudo apt install php-mysql

# Install Sail
composer require laravel/sail –dev
php artisan sail:install

# Install Livewire
composer require livewire/livewire
php artisan livewire:publish --assets

# If migrating doesn’t work, try changing the port in docker-compose.yml
# Example: ports: - '8080:80'

# Migrate using Sail
./vendor/bin/sail artisan migrate

# Install Tailwind CSS
# Install npm
sudo apt install npm

# Install nvm
wget -qO- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash

# Require Livewire
composer require livewire/livewire

# Install Node (example with version 14)
nvm install 14
nvm use 14

# Clear cache
./vendor/bin/sail artisan cache:clear

# Clear configuration cache
./vendor/bin/sail artisan config:clear

# Ensure things are properly loaded after making new migration
composer dump-autoload

# To access Laravel logs (using log facade)
# Enter Sail shell
sail shell
cd storage/logs
tail -n 50 laravel.log

# Clear config and cache config
php artisan config:clear
php artisan config:cache

# To allow folder connection
sail (or php) artisan storage:link

# Manually make the storage connection (for Windows users)
ln -s $(pwd)/storage/app/public $(pwd)/public/storage
sail (or php) artisan storage:link

# Grant all permissions on Linux
sudo chmod -R 777 *

# Example SQL queries
select * from useraccounts; 
select * from contacts; 
select * from contacts_numbers; 
select * from logs;

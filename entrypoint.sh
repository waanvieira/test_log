#!/bin/bash

#On error no such file entrypoint.sh, execute in terminal - dos2unix .docker\entrypoint.sh
chmod +x entrypoint.sh
cp .env.example .env
docker-compose up -d
chown -R www-data:www-data .
docker-compose exec db chown -R mysql:mysql /var/lib/mysql/ &&
docker-compose exec app composer update --ignore-platform-reqs &&
docker-compose exec app php artisan key:generate &&
docker-compose exec app php artisan migrate &&
docker-compose exec app php artisan storage:link &&
docker-compose exec app php artisan db:seed &&
docker-compose exec app php artisan test
# npm install
# npm run dev
# php-fpm

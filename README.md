# Dine2gether

A platform that brings people together over food.

## Back end
* cd Api
* composer install
* cp .env.example .env
* Edit .env
* php artisan key:generate
* php artisan migrate --seed
* chown -R www-data:www-data storage/
* Set up apache to host "Api/public" as "dine2gether.api"

## Front end
* cd Web
* npm install
* gulp init
* Set up apache to host "Web" as "dine2gether.local"
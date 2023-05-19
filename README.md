composer install

cp .env.example .env

create db fitness

config db
DB_CONNECTION=pgsql
DB_HOST=localhost
DB_PORT=5432
DB_DATABASE=fitness
DB_USERNAME=xxxxxxxx
DB_PASSWORD=yyyyyy

php artisan cache:clear
php artisan route:clear
php artisan config:cache
php artisan config:clear
php artisan view:clear

php artisan migrate
php artisan db:seed

cron
attendance:getlog
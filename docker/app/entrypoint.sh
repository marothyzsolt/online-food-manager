cd /var/www/

composer install --ignore-platform-reqs

php artisan migrate
php artisan optimize:clear
php artisan storage:link
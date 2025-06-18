# Instructions after cloning:
- run this command in your linux terminal
```
composer install && touch database/database.sqlite && cp .env.example .env && php artisan storage:link && php artisan migrate && php artisan key:generate
```
- run this command to create an administrator account
```
php artisan admin:create
```
- follow the instructions in the command line
```
```

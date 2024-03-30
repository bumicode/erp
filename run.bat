#!/bin/bash
php artisan migrate:fresh
php artisan db:seed
@REM npm run build
php artisan shield:super-admin --user=1
php artisan shield:generate --all
php artisan optimize:clear
php artisan serve

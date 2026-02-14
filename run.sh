#!/bin/sh

# បង្កើត file database បើវាមិនទាន់មាន
mkdir -p database
touch database/database.sqlite
chmod 777 database/database.sqlite

# Run migration
php artisan migrate --force

# ចាប់ផ្ដើម Apache ឱ្យដើរធម្មតា
apache2-foreground
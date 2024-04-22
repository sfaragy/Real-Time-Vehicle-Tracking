#!/bin/bash
set -e
#service cron restart
echo "* * * * * cd /var/www/html && /usr/local/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1" | crontab -
cron
exec "$@"
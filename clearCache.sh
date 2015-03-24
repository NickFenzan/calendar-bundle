php app/console cache:clear
php app/console cache:warmup
chmod 777 -R app/cache
chmod 777 -R app/logs
php app/console assets:install --symlink

php app/console cache:clear
php app/console cache:warmup
php app/console cache:clear --env=prod
php app/console cache:warmup --env=prod
chmod 777 -R app/cache
chmod 777 -R app/logs
php app/console assets:install --symlink
php app/console assetic:dump --env=prod


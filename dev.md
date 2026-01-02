#### testing php74

    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && exec bash"

    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && composer update"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && composer install"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && sh phpunit"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && git status"
    docker exec -it dev-php74 sh -c "cd /var/www/php74/yusam-hub/validator && git pull"

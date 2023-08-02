#### dockers

    docker exec -it yusam-php74 bash
    docker exec -it yusam-php74 sh -c "htop"

    docker exec -it yusam-php74 sh -c "cd /var/www/data/yusam/github/yusam-hub/validator && composer update"
    docker exec -it yusam-php74 sh -c "cd /var/www/data/yusam/github/yusam-hub/validator && sh phpunit"
<?php

$tutorials = [
    'https://www.digitalocean.com/community/tutorials/how-to-install-linux-nginx-mysql-php-lemp-stack-on-ubuntu-20-04',
    'https://www.digitalocean.com/community/tutorials/how-to-install-and-set-up-laravel-with-docker-compose-on-ubuntu-20-04'
];

return [
    'app_path' => __DIR__ . '/app/Command',
    'theme' => '\Unicorn',
    'db_file' => __DIR__ . '/data/stats.db',
    'table_name' => 'article_stats',
    'tutorial_urls' => $tutorials
];
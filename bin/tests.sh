#!/usr/bin/env bash

uid="$(id -u)"
gid="$(id -u)"

export uid=${uid}
export gid=${gid}

docker-compose run app php /var/www/vendor/phpunit/phpunit/phpunit --configuration /var/www/phpunit.xml --verbose

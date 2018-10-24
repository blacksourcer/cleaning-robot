#!/usr/bin/env bash

uid="$(id -u)"
gid="$(id -u)"

export uid=${uid}
export gid=${gid}

docker-compose run app /var/www/artisan $1 $2 $3

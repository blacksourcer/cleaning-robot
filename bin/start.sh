#!/usr/bin/env bash

uid="$(id -u)"
gid="$(id -u)"

export uid=${uid}
export gid=${gid}

docker-compose up

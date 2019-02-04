#!/usr/bin/env bash

# stop and remove any previously running docker containers from this branch
docker-compose stop
docker-compose rm

# stop and remove any previously running torque docker containers to avoid conflicts
TORQUE_CONTAINERS="$(docker ps -q -a --filter name=torque)"

[[ ! -z "$TORQUE_CONTAINERS" ]] && (docker stop $TORQUE_CONTAINERS && docker rm $TORQUE_CONTAINERS)

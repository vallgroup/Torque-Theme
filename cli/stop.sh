#!/usr/bin/env bash

# stop and remove any previously running docker containers from this branch
if [ "$IS_WINDOWS" == true ];
then
  COMPOSE_CONTAINERS="$(docker-compose.exe ps -q)"
  [[ ! -z "$COMPOSE_CONTAINERS" ]] && docker-compose.exe rm --stop
else
  COMPOSE_CONTAINERS="$(docker compose ps -q)"
  [[ ! -z "$COMPOSE_CONTAINERS" ]] && docker compose rm --stop
fi

# stop and remove any previously running torque docker containers to avoid conflicts
TORQUE_CONTAINERS="$(docker ps -q -a --filter name=torque)"

[[ ! -z "$TORQUE_CONTAINERS" ]] && (docker stop $TORQUE_CONTAINERS && docker rm $TORQUE_CONTAINERS)

exit 0

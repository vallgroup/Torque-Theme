#!/usr/bin/env bash

container_name=$(docker ps --filter "ancestor=$1" --format="{{.Names}}")

docker logs -f $container_name >/dev/null

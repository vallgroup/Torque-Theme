#!/usr/bin/env bash

docker-compose up -d &&  yarn workspace $1 start

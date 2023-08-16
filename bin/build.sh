#!/bin/bash

#sh "${PWD}/bin/clean.sh"
docker compose build \
"$@";
docker image prune -f && \
docker builder prune -f;
#!/bin/bash -xue
docker-compose run --rm app python -m main --seq=0 &
docker-compose run --rm app python -m main --seq=1 &
docker-compose run --rm app python -m main --seq=2 &
docker-compose run --rm app python -m main --seq=3 &
docker-compose run --rm app python -m main --seq=4
#!/bin/bash

docker-compose build --no-cache &&
docker-compose up -d &&
docker-compose exec laravel.test composer install &&
./vendor/bin/sail up -d &&
./vendor/bin/sail npm install &&
./vendor/bin/sail npm run dev

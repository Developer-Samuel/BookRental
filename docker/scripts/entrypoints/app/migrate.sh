#!/bin/sh
set -e

php artisan migrate:fresh --seed

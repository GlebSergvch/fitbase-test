#!/usr/bin/env bash
set -euo pipefail

docker-compose exec -T db mysql -u root -proot <<'SQL'
CREATE DATABASE IF NOT EXISTS fitbase_test
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS 'fitbase_user'@'%' IDENTIFIED BY 'secret';
ALTER USER 'fitbase_user'@'%' IDENTIFIED BY 'secret';
GRANT ALL PRIVILEGES ON fitbase_test.* TO 'fitbase_user'@'%';
FLUSH PRIVILEGES;
SQL

echo "fitbase_test created / privileges granted."

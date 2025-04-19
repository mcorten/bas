Handy commands:

create entity:
  docker compose exec bas-php-fpm php bin/console make:entity

database migration diff:
  docker compose exec bas-php-fpm php bin/console doctrine:migrations:diff

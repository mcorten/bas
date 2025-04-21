## Setup project

1. run: docker compose up
2. run: ./bin/setup
3. open your browser, go to localhost

## What is implemented
- [x] Message
  - [x] text
  - [x] recipient
  - [x] created at
- [ ] Expiry
  - [x] read once, then delete
  - [ ] delete after X period
- [x] Reading Message:
  - [x] Provide identifier for message
  - [ ] Provide decryption key <- we use a static encryption key for now
- [ ] Recipient
  - [ ] identifier <- for now we use the recipient name as identifier


## Development
Handy commands:

create entity:
  docker compose exec bas-php-fpm php bin/console make:entity

database migration diff:
  docker compose exec bas-php-fpm php bin/console doctrine:migrations:diff

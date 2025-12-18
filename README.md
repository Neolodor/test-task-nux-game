### Test task

#### Stack

1. Php-fpm 8.4
2. Laravel 12
3. PostgreSQL 18
4. Nginx 1.2
5. Redis 8
6. Docker-compose v2.23

#### Local setup

1. Add mapping to hosts file for project setup `172.30.1.11 nux-game.test.task` where:
- `172.30.1.11` - is a host fixed ip
- `nux-game.test.task` - desired host to use in browser to access application. Can be changed to any host.
2. Clone this repo and open its directory on your local env.
3. Build the project<br> `docker-compose build`
4. Launch it <br>`docker-compose up -d`
5. Setup dependencies <br>`docker-compose exec php composer install`
6. Run migrations <br>`docker-compose exec php artisan migrate`

#### P.S.

App uses https over self-signed SSL certificates. Before accessing app allow self-signed SSL certificates usage in your browser.

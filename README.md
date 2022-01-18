## run project
1)
```bash
git clone https://github.com/mohamedElheni681/blogging_app_test.git
```
2)
```bash
cd blogging_app_test/
```
3)
```bash
composer install
```
#### Note: If you face Class '***ServiceProvider' not found run composer update
4)
```bash
cp .env.example .env
```
5)
```bash
php artisan config:cache
```
6)
```bash
php artisan key:generate
```
7)
```bash
docker network create shared_blog
```
8)
```bash
./vendor/bin/sail up -d
```
9)
```bash
./vendor/bin/sail artisan migrate
```
#### Note If you face ".../storage/logs" and its not buildable: Permissions denied ? run   
- ./vendor/bin/sail artisan artisan route:clear
- ./vendor/bin/sail artisan artisan config:clear
- ./vendor/bin/sail artisan artisan cache:clear
- ./vendor/bin/sail artisan config:cache
10)
```bash
./vendor/bin/sail artisan command:role-permission
```
11)
```bash
./vendor/bin/sail artisan migrate --seed
```

#### seed will create customer user with admin role:
### email: customer@test.com
### password: password

#### Application ports:
#### blogging platform: 
- http://localhost:8084/
#### phpMyAdmin:
- http://localhost:8083/

## RUN AUTO IMPORT COMMAND
```bash
./vendor/bin/sail artisan command:import-posts
```

## RUN TEST
```bash
./vendor/bin/sail artisan test
```
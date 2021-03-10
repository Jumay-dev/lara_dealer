<p align="center"><a href="https://ds-med.ru" target="_blank"><img src="https://ds-med.ru/wp-content/uploads/2020/03/logoDS-1.png" width="400"></a></p>

## About Project

This project developing for backend purposes of Projects Authorisation System (PAS) DS.Med.

## How to install
As usual:

git clone

- composer install

- php artisan migrate

- after this, you need to register new user

Don't forget about: 
- php artisan key:generate
- php artisan jwt:secret
- php artisan cache:clear
- php artisan config:clear

# How to serve
- php artisan serve

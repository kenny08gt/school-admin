# School Kit

## Introduction
[School Kit](http://schoolkit.alanhurtarte.com) is a simple to use, with rich functionalities to help school oweners to manage the staff, courses, grades and scores.

It's implemented with [Laravue](https://laravue.dev).

## Techologie stack 
* Laravel
* Vue
* Vue routter
* Element UI
* Css
* Mysql
* Sass
* Php


## Getting started
This project is built on top of fresh latest version Laravel (5.8). You should check the installation guide of Laravel [here](https://laravel.com/docs/5.8)

```bash
# Clone the project and run composer
composer create-project tuandm/laravue
cd laravue

# Migration and DB seeder (after changing your DB settings in .env)
php artisan migrate --seed

# Generate JWT secret key
php artisan jwt:secret

# install dependency
npm install

# develop
npm run dev # or npm run watch

# Build on production
npm run production
```

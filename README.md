# Laravel and Docker Boilerplate
## _A boilerplate for API's REST development._

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

This boilerplate will be useful for anyone who wants to create a REST API in Laravel with a Docker environment.
To create it, we use:

- :elephant: Laravel 7 :elephant:
- :dolphin: MySQL :dolphin:
- :whale: Docker :whale:
- :chart: TDD :chart:

## Get Started

- Make a git clone of the project
- Copy the .env.example file and rename to .env, then make the changes.
- Up the containers in Docker.
- Run the following commands from a terminal:
    ```sh
         docker-compose exec app composer install
         docker-compose exec app php artisan migrate:fresh --seed
         docker-compose exec app php artisan apidoc:generate
    ```
                     A new php development server will be started in: localhost:8000

    These commands will, respectively: update project dependencies, run database migrations and generate API documentation(localhost:8000/docs to access).

## External packages and services

This project is currently extended with the following packages and services.
Instructions on how to use them in your own app are linked below.

| Plugin | Doc |
| ------ | ------ |
| JWT | https://jwt-auth.readthedocs.io/en/develop/
| Laravel API Doc Generator | https://beyondco.de/docs/laravel-apidoc-generator/getting-started/installation |
| EloquentFilter |https://github.com/Tucker-Eric/EloquentFilter |
| Laravel Fractal | https://fractal.thephpleague.com/ |

## Development

#### Want to contribute? Great!

This project can grow even more with your contribution! 
Suggestions are always welcome!


## License

MIT

**Free Software, Hell Yeah!**

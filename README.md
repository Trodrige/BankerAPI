# Banking API Documentation

This repository contains a Laravel Lumen installation which was used to build a simple API for a fake bank.

## Why Lumen?
Laravel Lumen is a stunningly fast PHP micro-framework for building web applications with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Lumen attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as routing, database abstraction, queueing, and caching.

## Official Documentation

Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).


## Project Requirements

- Implement assignment using:
  - Language: PHP
  - Framework: Laravel
- Define API routes to:
  - Authenticate users
  - Create a new bank account for a customer, with an initial deposit amount.
  - Transfer amounts between any two accounts, including those owned by different customers.
  - Retrieve balances for a given account.
  - Retrieve transfer history for a given account.
- All endpoints should only be accessible if an API key is passed as a header.
- All role-based endpoints should require authentication.
- Write tests for the business logic.
- Provide a documentation that says what endpoints are available and the kind of parameters they expect.
- Design all required models and routes for the API.

## API Documentation (postman)

You can find the documentation for the endpoints for this simple API [HERE](https://documenter.getpostman.com/view/3672274/UVRDHkwn).

Note: All the endpoints require a Bearer token to work.


## Getting Started

First, clone the repo:
```bash
$ git clone git@github.com:Trodrige/BankerAPI.git
```

#### Laravel Homestead
You can use Laravel Homestead globally or per project for local development.
Follow the [Installation Guide](https://laravel.com/docs/5.5/homestead#installation-and-setup).

#### Install dependencies
```
$ cd BankerAPI
$ composer install
```

#### Configure the Environment
Create `.env` file:
```
$ cat .env.example > .env
```

If you want you can edit database name, database username and database password.

#### Migrations and Seed the database with fake data
First, we need connect to the database. For homestead user, login using default homestead username and password:
```bash
$ mysql -uhomestead -psecret
```

Then create a database:
```bash
mysql> CREATE DATABASE banking_api;
```

And also create test database:
```bash
mysql> CREATE DATABASE bankingapi_test;
```

Run the Artisan migrate command with seed:
```bash
$ php artisan migrate --seed
```

Create "personal access" and "password grant" clients which will be used to generate access tokens:
```bash
$ php artisan passport:install
```

You can find those clients in ```oauth_clients``` table.

#### Serving the application
```bash
$ php -S localhost:8000 -t public
```

### OAuth2 Routes
Visit [dusterio/lumen-passport](https://github.com/dusterio/lumen-passport/blob/master/README.md#installed-routes) to see all the available ```OAuth2``` routes.

### Creating access_token
Since Laravel Passport doesn't restrict any user creating any valid scope. I had to create a route and controller to restrict user creating access token only with permitted scopes. For creating access_token we have to use the ```v1/oauth/token``` route. Here is an example of creating access_token for grant_type password with [Postman.](https://www.getpostman.com/)

![access_token creation](/public/images/banking_api-get-access-token.png?raw=true "access_token creation example")


## TODOs
1. Add a service file for handling arithmetic calculations like adjusting account balances after a transaction.
2. Implement Validation of fields before handling requests.
3. Use [Fractal](http://fractal.thephpleague.com/) to treat API responses.
4. Consider Pagination when listing large sets of data.
5. Build Process with [Travis CI](https://travis-ci.org/).
6. Scope based Authorization.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

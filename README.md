## Usage

### Installation

Install the dependencies

```sh
$ composer install Or unzip the vendor folder
```

Change env file
```
$ .env.example to .env
```

```sh
$ Update the env file database connection
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_management
DB_USERNAME=root
DB_PASSWORD=
```

Generate project key 
```sh
$ php artisan key:generate
```


migrate database

```sh
$ php artisan migrate 
```

seed database

```sh
$ php artisan db:seed
```

start developement server

```sh
$ php artisan serve
```

Login with the credentials

```sh
$ Email : developer@test.com
$ Password : Test@Dev123#
```

# Search Events API

## Requirements

- [Docker](https://www.docker.com/products/docker-desktop)
- [Postman](https://www.postman.com/downloads/)

## Info

- [Laravel 9 Info](https://laravel.com/docs/9.x/installation)

## Installation/Configuration

### Install dependencies

#### macOS / Linux

```
docker run --rm -v $(pwd):/app composer install
```

#### Windows (Git Bash)

```
docker run --rm -v /$(pwd):/app composer install
```

#### Windows (Powershell)

```
docker run --rm -v ${PWD}:/app composer install
```

### Copy all file .env.example to .env

In terminal if you use macOS / Linux / Git Bash(Windows)

```
cp .env.example .env
```

Change database configurations in **.env**

```
DB_CONNECTION=mysql
DB_HOST=mysql_search_events
DB_PORT=3306
DB_DATABASE=yourdatabasename
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### Configure PHPUnit file

change value line **25** phpunit.xml in **phpunit.xml**

```
<server name="DB_DATABASE" value="yourdatabasename"/>
```

### Detach the application

```
docker-compose up -d
```

### Generate APP Key

```
docker-compose exec app php artisan key:generate
```

### Run the migrations and seed script

```
docker-compose exec app php artisan migrate --seed
```

### URL http://localhost:8888

### Login

- Go your database and seed the fake users created and choose one
- Password for users -> **password**

### Configure Access Local Database

```
Host: 127.0.0.1
Port: 3308
Username : root
Password: yourdatabasepassword
```

### Endpoints

> Headers must include Accept:application/json

#### Create a Token

- **POST** - http://localhost:8000/api/login

##### Data example

````
{
    "email":"example@example.com",
    "password": "password",
}
````


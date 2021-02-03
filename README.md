Users Management API
====================

Users Management API is a simple REST api written in PHP 7 using the lumen framework.

I had fun throwing this project together and will try my hand at making a database migrations and routing micro app in order to deepen my understand of regex and PHP as a whole.

# Installation

Users Management API requires `PHP` v7.4+ to run.

This API is built using [lumen][lumen]

There are two methods to run the project using your local development or production enviroment or via docker.

## Required Before Install

- [git][git]
- [composer][composer]

```sh
$ git clone https://github.com/swayechateau/protected-users-api.git
$ cd protected-users-api
$ cp .env.example .env
```

Edit the .env file and set your API_KEY before continuing. the default is `tryme` 
```env
APP_NAME='Users Api'
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=UTC

# users management test api access token
UMT_API_KEY='tryme'

# use connection and host only for non docker setups
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
# required for docker-compose
DB_PORT=3306
DB_DATABASE=users_api_db
DB_USERNAME=root
DB_PASSWORD=root

# docker mysql env
MYSQL_ROOT_PASSWORD=d032CNpFgG7g6rvQJFs7nd3A7
HOST_PORT=8888
UID=1000
```

### Normal Setup

Please run the following command to install.

```sh
$ composer install
```

The application can be preloaded via the browser by going to the install route
`curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET http://localhost:8888/install`
or by running this command

```sh
$ php artisan migrate --seed
```

Load Development Server

```sh
$ php -S localhost:8888 -t public
```

## How it works

The application use the token specificed in the `.env` file to protect api route calls.

All protected routes check the header or query string for `api_token` - if the token is found and matches then happy times are had.

For a new instant please see the install routes

## Tables

Curently the application has only one table besides the migrations table

### Users Table
The users table has the following fields 

| Field      | Type        | Unique |
| ---------- | ----------- | ------ |
| id         | BIGINT(20)  | YES    |
| username   | VARCHAR(20) | YES    |
| first_name | varchar(50) | NO     |
| last_name  | varchar(50) | NO     |
| dark_mode  | TINYINT(1)  | NO     |
| created_at | TIMESTAMP   | NO     |
| updated_at | TIMESTAMP   | NO     |


Api Routes
==============

## Install 

Accepted query parameters

| Query      | Type        | Requred |
| ---------- | ----------- | ------  |
| api_token  | STRING      | YES     |
| reinstall  | BOOL        | No      |

```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET http://localhost:8888/install
```
to reinstall set the `reinstall` query parameter to true

```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET "http://localhost:8888/install?reinstall=true"
```

#### Expected Result
```json
{
    "installed":true,
    "message":"yes mate get in - setup ran successfully"
}
```

## Search 

Accepted query parameters

| Query      | Type        | Requred |
| ---------- | ----------- | ------  |
| api_token  | STRING      | YES     |
| q          | STRING      | YES     |

The search route will search all users where the query param `q` is like the users first name, last name or username

```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET "http://localhost:8888/install?q=e"
```

#### Expected Result
```json
{
    "search_term":"e",
    "results":[
        {
            "id":1,
            "username":"spacex",
            "first_name":"elon",
            "last_name":"musk",
            "dark_mode":1,
            "created_at":"2021-02-03 15:03:44",
            "updated_at":"2021-02-03 15:03:44"
        },
        {
            "id":5,
            "username":"wallet-bully",
            "first_name":"gabe",
            "last_name":"newell",
            "dark_mode":1,
            "created_at":"2021-02-03 15:03:44",
            "updated_at":"2021-02-03 15:03:44"
        },
        {
            "id":7,
            "username":"winning",
            "first_name":"charlie",
            "last_name":"sheen",
            "dark_mode":0,
            "created_at":"2021-02-03 15:03:44",
            "updated_at":"2021-02-03 15:03:44"
        }
    ],
    "total":3
}

```

## Users
 - GET Users
 - GET User
 - POST User
 - PUT User
 - DELETE User
  
 - GET Toggle User Dark Mode
  
### GET Users
```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET http://localhost:8888/users
```

#### Expected Result
```json
[
    {
        "id":1,
        "username":"spacex",
        "first_name":"elon",
        "last_name":"musk",
        "dark_mode":1,
        "created_at":"2021-02-03T14:21:48.000000Z",
        "updated_at":"2021-02-03T14:21:48.000000Z"
    },
    {
        "id":2,
        "username":"samurai",
        "first_name":"miyamoto",
        "last_name":"musashi",
        "dark_mode":0,
        "created_at":"2021-02-03T14:21:49.000000Z",
        "updated_at":"2021-02-03T14:21:49.000000Z"
    }
    ....
    ]
```

### GET User
```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -H "Content-Type: application/json" -H "Accept: application/json" -X GET http://localhost:8888/users/5
```
#### Expected Result
```json
{
    "id":5,
    "username":"wallet-bully",
    "first_name":"gabe",
    "last_name":"newell",
    "dark_mode":1,
    "created_at":"2021-02-03T14:21:49.000000Z",
    "updated_at":"2021-02-03T14:21:49.000000Z"
}
```

### POST User
```sh
curl --data "first_name=yoda&last_name=rover"  -H "api_token:{{ ENV_API_KEY }}" -X POST http://localhost:8888/users
```
#### Expected Result
```json
{
    "id":8,
    "username":"yoda",
    "first_name":"yoda",
    "last_name":"rover",
    "dark_mode":0,
    "created_at":"2021-02-03T15:21:49.000000Z",
    "updated_at":"2021-02-03T15:21:49.000000Z"
}
```

### PUT User
```sh
curl --data "first_name=yoda1"  -H "api_token:{{ ENV_API_KEY }}" -X PUT http://localhost:8888/users/5
```
#### Expected Result
```json
{
    "id":8,
    "username":"yoda",
    "first_name":"yoda1",
    "last_name":"rover",
    "dark_mode":0,
    "created_at":"2021-02-03T15:21:49.000000Z",
    "updated_at":"2021-02-03T15:21:49.000000Z"
}
```

### DELETE User
```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X DELETE http://localhost:8888/users/1
```
#### Expected Result
```json
{
    "code":410,
    "message":"User has been disposed of \u00ac_\u00ac"
}
```

### GET Toggle User Dark Mode

```sh
curl -i -H "api_token:{{ ENV_API_KEY }}" -X GET http://localhost:8888/users/5/tdm
```

#### Expected Result
```json
{
    "dark_mode":true,
    "message":"Welcome to the Darkside my child! ^_^"
}
```

<!-- For github pages -->
[get users]: /users?api_token=tryme
[get user]: /users/5?api_token=tryme
[toggle darkmode]: /users/7/tdm?api_token=tryme

[search username]: /search?q=samura&api_token=tryme
[search firstname]: /search?q=gabe&api_token=tryme

<!-- Doc links -->
[lumen]: https://lumen.laravel.com
[git]: https://git-scm.com/downloads/
[composer]:https://getcomposer.org/
[docker]: https://www.docker.com/
[docker compose install]:https://docs.docker.com/compose/install/
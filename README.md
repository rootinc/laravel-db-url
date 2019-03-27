# laravel-db-uri
Package to translate a database URI into database config values.

This is meant to help prevent the need for manually parsing database URIs that come from Heroku or are just more convenient
to use than manually parsing a URI into it's host, password, username, port, (etc.) components.

This __will overwrite__, at runtime, any `default` database connection values for `host`, `port`, `username`, `password`, and `database`

__THIS PACKAGE HAS NOT BEEN RELEASED PUBLICLY AND CANNOT YET BE INSTALLED VIA COMPOSER WITHOUT ROOTINC REPO ACCESS__ 

## Requirements
(package will likely work with prior versions of Laravel and PHP but is untested)
- PHP 7.1.3
- Laravel 5.8

## Installation
```
// composer.json
...
    "repositories": [
        {
            "type": "git",
            "url":  "git@github.com:rootinc/laravel-db-uri.git"
        }
    ],
...
```
`$ composer require rootinc/laravel-db-uri`
You may, then, need to authenticate to Github at the command line.


## Configuration
The package will automatically map the `default` driver to the parsed values from the environment variable `DATABASE_URL`.

Add a `DATABASE_URL` entry to your `.env` or server environment with a URI to your default database.
`DATABASE_URL=postgresql://username:password@localhost:5432/database-name`

This will overwrite database connection values for `host`, `port`, `username`, `password`, and `database`


#### Customization
Override that by publishing the config file and setting it's values in `config/db-uri.php`.

`php artisan vendor:publish --tag=db-uri`

```
// config/db-uri.php
return [
  'redis' => 'SOME_REDIS_URL',
  'mysql' => 'SOME_MYSQL_URL',
];
```


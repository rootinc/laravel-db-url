# laravel-db-uri
Package to translate a database URI into database config values.

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
Add a `DATABASE_URL` entry to your `.env` or server environment with a URI to your default database.
`DATABASE_URL=postgresql://username:password@localhost:5432/database-name`

This is meant to help prevent the need for manually parsing database URIs that come from Heroku or are just more convenient
to use than manually parsing a URI into it's host, password, username, port, (etc.) components.

It __will__ overwrite your individual environment variables such as: `DB_HOST`, `DB_USERNAME`, etc..

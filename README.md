# Laravel Database URL
Drop-in package to translate a database URL into database config values. No more need to add logic to your
`config/database.php` file.

This is meant to help prevent the need for manually parsing database URLs, like the ones that come from Heroku or AWS.
It will take a URL and assign host, password, username, port, (etc.) components to the default driver or
specific driver(s) of your choosing.

This __will override__, at runtime, any `default` database connection values for `host`, `port`, `username`, `password`, and `database`

## Requirements
(package will likely work with prior versions of Laravel and PHP but is untested)
- PHP >= 7.1.3
- Laravel >= 5.6

## Installation
`$ composer require rootinc/laravel-db-url`

## Configuration
The package will automatically map the parsed values from the environment variable `DATABASE_URL` to the `default` database connection.

Add a `DATABASE_URL` entry to your `.env` or server environment with a URL to your default database.
`DATABASE_URL=postgresql://username:password@localhost:5432/database-name`

This will overwrite database connection values for `host`, `port`, `username`, `password`, and `database`


## Customization
Override default behaviour by publishing the config file and setting values.

`$ php artisan vendor:publish --tag=db-url`

Set any database connections by supplying `default` or the key path, like `connections.pgsql`, or `redis`
to have a URL mapped onto the connection at that key path.

config/db-url.php
```
return [
  'default' => 'SOME_DATABASE_URL', // "default" resolves key path from default key
  'connections.pgsql' => 'OTHER_PGSQL_URL', // Set the "pgsql" driver with different URL. Same when "default" set to "pgsql"
  'connections.mysql' => 'OTHER_MYSQL_URL', // Set the "mysql" driver with different URL
];
```
.env
```
DATABASE_URL=postgresql://username:password@localhost:5432/database-name
OTHER_MYSQL_URL=mysql://username:password@localhost:3306/db_example
```



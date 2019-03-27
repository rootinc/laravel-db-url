# Laravel Database URI
Drop-in package to translate a database URI into database config values. No more need to add logic to your
`config/database.php` file.

This is meant to help prevent the need for manually parsing database URIs, like the ones that come from Heroku or AWS.
to use than manually parsing a URI into it's host, password, username, port, (etc.) components.

This __will override__, at runtime, any `default` database connection values for `host`, `port`, `username`, `password`, and `database`

## Requirements
(package will likely work with prior versions of Laravel and PHP but is untested)
- PHP >= 7.1.3
- Laravel >= 5.6

## Installation
`$ composer require rootinc/laravel-db-uri`

## Configuration
The package will automatically map the parsed values from the environment variable `DATABASE_URL` to the `default` database connection.

Add a `DATABASE_URL` entry to your `.env` or server environment with a URI to your default database.
`DATABASE_URL=postgresql://username:password@localhost:5432/database-name`

This will overwrite database connection values for `host`, `port`, `username`, `password`, and `database`


#### Customization
Override that by publishing the config file and setting it's values in `config/db-uri.php`.

`php artisan vendor:publish --tag=db-uri`

```
// config/db-uri.php
return [
  'default' => 'DATABASE_URL', // default
  'mysql' => 'OTHER_MYSQL_URL', // custom override for the mysql driver
];
```


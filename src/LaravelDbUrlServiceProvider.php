<?php

namespace Rootinc\LaravelDbUrl;

use Illuminate\Support\ServiceProvider;

class LaravelDbUrlServiceProvider extends ServiceProvider
{

  /**
   * URL component keys mapped to Laravel database config keys
   * @var array
   */
  private $config_map = [
    'host' => 'host',
    'port' => 'port',
    'user' => 'username',
    'pass' => 'password',
    'path' => 'database',
  ];

  /**
   * @return  void
   */
  public function boot()
  {
  }

  /**
   * @throws \Exception
   * @return  void
   */
  public function register()
  {
    $this->publishes([
      __DIR__.'/config/db-url.php' => config_path('db-url.php')
    ], 'db-url');

    $this->mergeConfigFrom(
      __DIR__.'/config/db-url.php', 'db-url'
    );

    // All driver/connection mappings from config
    $connections = config('db-url');

    // Loop and set each connection
    foreach($connections as $driver_path => $connection_key) {

      // If "default" driver, look up the value for the actual connection
      // "default" resolves to something like "connections.pgsql"
      $driver_path = $driver_path === 'default' ? 'connections.' . config('database.default') : $driver_path;

      // Get the DATABASE_URL env value or skip out
      if(empty($url = env($connection_key))) continue;

      // Try to parse it
      if(!$components = parse_url($url)) throw new \Exception('Database URL may be malformed.');

      // Set each config
      foreach($this->config_map as $component_key => $config_key) {
        // Skip setting when no value
        if(empty($components[$component_key])) continue;
        config(["database.{$driver_path}.{$config_key}" => $this->clean($component_key, $components[$component_key])]);
      }
    }
  }

  /**
   * Provide dynamic methods like `cleanHost` or `cleanPath`
   * @param $component_key - string
   * @param $value - string
   * @return mixed
   */
  private function clean($component_key, $value) {
    $upcase_key = ucfirst($component_key);
    $method_name = "clean{$upcase_key}";
    // If method not defined, return value
    if(!$exists = method_exists($this, $method_name)) return $value;

    // @todo: Speed up - said to be a slower way of dynamically calling methods.
    return call_user_func([$this, $method_name], $value);
  }


  /**
   * Runs when we get to the "path" URL component key
   * @param $value
   * @return string
   */
  private function cleanPath($value) {
    // remove the leading forward slash from the path component
    return trim($value, '/');
  }

}
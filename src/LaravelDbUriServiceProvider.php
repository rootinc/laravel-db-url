<?php

namespace Rootinc\LaravelDbUri;

use Illuminate\Support\ServiceProvider;

class LaravelDbUriServiceProvider extends ServiceProvider
{
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
    // Only operates on database set as `default`
    $connection = config('database.default');
    // keys are URL component keys and values are Laravel database connection config keys

    // Get the DATABASE_URL env value or skip out
    if(empty($url = env('DATABASE_URL'))) return;

    // Try to parse it
    if(!$components = parse_url($url)) throw new \Exception('Database URL may be malformed.');

    // Set each config
    array_walk($this->config_map, function($config_key, $components_key) use($components, $connection){
      config(["database.connections.{$connection}.{$config_key}" => $this->clean($components_key, $components[$components_key])]);
    });
    var_dump(config("database.connections.{$connection}"));

  }

  // Provide dynamic methods as `cleanHost` or `cleanDatabase`
  private function clean($component_key, $value) {
    $upcase_key = ucfirst($component_key);
    $method_name = "clean{$upcase_key}";
    // If method not defined, return value
    if(!$exists = method_exists($this, $method_name)) return $value;

    return call_user_func([$this, $method_name], $value);
  }

  private function cleanPath($value) {
    return trim($value, '/');
  }

}
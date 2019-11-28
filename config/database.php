<?php

return [

  'default' => env('DB_CONNECTION', 'pgsql'),
  'migrations' => 'migrations',
  'connections' => [
      'pgsql' => [
          'driver' => 'pgsql',
          'host' => env('DB_HOST', '127.0.0.1'),
          'port' => env('DB_PORT', '5432'),
          'database' => env('DB_DATABASE', 'progreso'),
          'username' => env('DB_USERNAME', 'postgres'),
          'password' => env('DB_PASSWORD', '1234'),
          'charset' => 'utf8',
          'prefix' => '',
          'prefix_indexes' => true,
      ],

      'mysql' => [
          'driver' => 'mysql',
          'host' => env('DB_HOST2', 'prolimpia.duckdns.org'),
          'port' => env('DB_PORT2', '3306'),
          'database' => env('DB_DATABASE2', 'prolimpia'),
          'username' => env('DB_USERNAME2', 'smapap'),
          'password' => env('DB_PASSWORD2', ''),
          'charset' => 'utf8',
          'prefix' => '',
          'prefix_indexes' => true,
      ],
  ],
];
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

      'pgsql2' => [
          'driver' => 'pgsql',
          'host' => env('DB_HOST', '127.0.0.1'),
          'port' => env('DB_PORT', '5432'),
          'database' => env('DB_DATABASE2', 'progreso2'),
          'username' => env('DB_USERNAME', 'postgres'),
          'password' => env('DB_PASSWORD', '1234'),
          'charset' => 'utf8',
          'prefix' => '',
          'prefix_indexes' => true,
      ],
  ],
];
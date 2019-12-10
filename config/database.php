<?php

return [

  'default' => env('DB_CONNECTION', 'mysql'),
  'migrations' => 'migrations',
  'connections' => [
      'mysql' => [
          'driver' => 'mysql',
          'host' => env('DB_HOST', 'prolimpia.duckdns.org'),
          'port' => env('DB_PORT', '3306'),
          'database' => env('DB_DATABASE', 'prolimpiaapirest'),
          'username' => env('DB_USERNAME', 'smapap'),
          'password' => env('DB_PASSWORD', ''),
          'charset' => 'utf8',
          'prefix' => '',
          'prefix_indexes' => true,
      ],

      'mysql2' => [
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
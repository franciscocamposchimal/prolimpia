<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection = 'mysql';
    protected $table = 'recolecta_usuarios';
    protected $primaryKey = 'usr_numcom';
    public $timestamps = false;
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection = 'mysql';
    protected $table = 'recolecta_usuarios2';
    protected $primaryKey = 'usr_numcon';
    public $timestamps = false;
}

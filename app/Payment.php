<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mysql';
    protected $table = 'recolecta_cobros';
    protected $primaryKey = 'id_cb';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_cb',
        'numcon', 
        'nombre', 
        'domici', 
        'zona', 
        'ruta', 
        'progr', 
        'cvetar',
        'fpago',
        'faviso',
        'saldoant',
        'saldopost',
        'iva',
        'total',
        'efectivo',
        'cambio',
        'tipopago',
        'tusuario',
        'tpc',
        'referencia',
        'estado',
    ];

}

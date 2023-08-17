<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    use HasFactory;

     // Nombre de la tabla en la base de datos
     protected $table = 'tbl_repo_movi';

     // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
     protected $primaryKey = 'cod_movimiento';

     public $timestamps = false;

     protected $fillable = [
        'usuario', // Agrega el atributo 'usuario' aquí
        'fecha_hora_mov',
        'tipo_mov',
        'detalle',
        
    ];
}

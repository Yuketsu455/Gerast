<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingresos extends Model
{
    use HasFactory;


    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_repo_ingre';

    // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
    protected $primaryKey = 'cod_movimiento';

    // Indica si la llave primaria es autoincremental (por defecto, Eloquent asume 'true')
    public $incrementing = true;

    // Atributos que se pueden asignar de manera masiva
    protected $fillable = ['usuario', 'fecha_hora_ingreso', 'fecha_hora_salida'];

    protected $casts = [
        'fecha_hora_ingreso' => 'datetime',
        'fecha_hora_salida' => 'datetime',
    ];

    // Resto del código del modelo...
    public $timestamps = false;
    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(usuarios::class, 'correo');
    }
    
}

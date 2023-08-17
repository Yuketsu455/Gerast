<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\clientes;
use App\Events\MovimientoEvent;
use Illuminate\Http\Request;


class tiquetes extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_tiquetes';

    // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
    protected $primaryKey = 'num_caso';
   // public $incrementing = true;

    // Indica si la llave primaria es autoincremental (por defecto, Eloquent asume 'true')
    public $incrementing = false;

    // Atributos que se pueden asignar de manera masiva
    protected $fillable = [
        // Agrega aquí los nombres de las columnas de la tabla que desees permitir que se llenen masivamente
       'num_caso',
       'tipo_equipo',
       'id_cliente',
       'usuario',
       'marca',
       'modelo',
       'serie',
       'cargador',
       'garantia',
       'fecha',
       'prioridad',
       'estado_tiquete',
       'fotografia'

    ];

    public $timestamps = false;
    // Resto del código del modelo...
    
    public function verificarnum_caso(Request $request)
    {
        $request->validate([
            'num_caso' => 'required|unique:users,num_caso', // Aquí se realiza la validación única en la tabla "users" y columna "cedula".
        ], [
            'num_caso.unique' => 'La Tiquete ingresada ya se encuentra en el sistema.',
        ]);

        // Continuar con el flujo normal si la cédula es válida.
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($tiquetes) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Tiquetes', 'Se ha insertado un registro en tiquetess con numero de caso: ' . $tiquetes->num_caso));
        });

        static::updated(function ($tiquetes) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Tiquetes', 'Se ha editado un registro en tiquetes con numero de caso: ' . $tiquetes->num_caso));
        });

        static::deleted(function ($tiquetes) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Tiquetes', 'Se ha eliminado un registro en tiquetes con numero de caso: ' . $tiquetes->num_caso));
        });

    }
}

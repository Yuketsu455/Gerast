<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\MovimientoEvent;
use Illuminate\Http\Request;


class clientes extends Model
{    
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_clientes';

    // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
    protected $primaryKey = 'cedula';
   // public $incrementing = true;

    // Indica si la llave primaria es autoincremental (por defecto, Eloquent asume 'true')
    public $incrementing = false;

    // Atributos que se pueden asignar de manera masiva
    protected $fillable = [
        // Agrega aquí los nombres de las columnas de la tabla que desees permitir que se llenen masivamente
       'nombre',
       'apellidos',
       'cedula',
       'correo',
       'telefono'
    ];

    public $timestamps = false;
    // Resto del código del modelo...
    
    public function verificarCedula(Request $request)
    {
        $request->validate([
            'cedula' => 'required|unique:users,cedula', // Aquí se realiza la validación única en la tabla "users" y columna "cedula".
        ], [
            'cedula.unique' => 'La cédula ingresada ya se encuentra en el sistema.',
        ]);

        // Continuar con el flujo normal si la cédula es válida.
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($cliente) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Clientes', 'Se ha insertado un registro en clientes con Cédula: ' . $cliente->cedula));
        });

        static::updated(function ($cliente) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Clientes', 'Se ha editado un registro en clientes con Cédula: ' . $cliente->cedula));
        });

        
        static::deleted(function ($cliente) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Clientes', 'Se ha eliminado un registro en clientes con Cédula: ' . $cliente->cedula));
        });
    }
}

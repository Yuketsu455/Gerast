<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\MovimientoEvent;

class Operaciones extends Model
{
    use HasFactory;

 // id de la tabla en la base de datos
 protected $table = 'tbl_rol_operacion';

 // id de la llave primaria (por defecto, Eloquent asume que es 'id')
 protected $primaryKey = 'id';

 public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::created(function ($Operaciones) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Operaciones', 'Se ha insertado un registro en Operaciones con id: ' . $Operaciones->id));
        });

        static::updated(function ($Operaciones) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Operaciones', 'Se ha editado un registro en en Operaciones con id: ' .$Operaciones->id));
        });

        static::deleted(function ($Operaciones) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Operaciones', 'Se ha eliminado un registro en en Operaciones con id: ' . $Operaciones->id));
        });
    }
}

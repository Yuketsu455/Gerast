<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\MovimientoEvent;

class Permisos extends Model
{
    use HasFactory;

    protected $table = 'tbl_operaciones';

    public $timestamps = false;

    // Relación con el modelo "Rol"
    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'tbl_rol_operacion', 'idOperacion', 'idRol');
    }

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'idModulo');
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($Permisos) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Permisos', 'Se ha insertado un registro en Permisos con nombre: ' . $Permisos->nombre));
        });

        static::updated(function ($Permisos) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Permisos', 'Se ha editado un registro en en Permisos con nombre: ' .$Permisos->nombre));
        });

        static::deleted(function ($Permisos) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Permisos', 'Se ha eliminado un registro en en Permisos con nombre: ' . $Permisos->nombre));
        });
    }
}
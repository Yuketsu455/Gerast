<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\MovimientoEvent;
use App\Models\usuarios;

class Roles extends Model
{
    use HasFactory;
    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_roles';

    // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
    protected $primaryKey = 'id';
   // public $incrementing = true;

    // Indica si la llave primaria es autoincremental (por defecto, Eloquent asume 'true')
    public $incrementing = true;

    // Atributos que se pueden asignar de manera masiva
    protected $fillable = [
        // Agrega aquí los nombres de las columnas de la tabla que desees permitir que se llenen masivamente
        'id',
        'nombre'
    ];
    public static function boot()
    {
        parent::boot();

        static::created(function ($Roles) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Roles', 'Se ha insertado un registro en Roles con nombre: ' . $Roles->nombre));
        });

        static::updated(function ($Roles) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Roles', 'Se ha editado un registro en en Roles con nombre: ' .$Roles->nombre));
        });

        static::deleted(function ($Roles) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Roles', 'Se ha eliminado un registro en en Roles con nombre: ' . $Roles->nombre));
        });
    }
    public $timestamps = false;
    // Resto del código del modelo...

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'idrol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permisos::class, 'tbl_rol_operacion', 'idRol', 'idOperacion');
    }
}

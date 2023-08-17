<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Events\MovimientoEvent;

class usuarios extends Model implements Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // Nombre de la tabla en la base de datos
    protected $table = 'tbl_usuarios';

    // Nombre de la llave primaria (por defecto, Eloquent asume que es 'id')
    protected $primaryKey = 'cedula';

    // Indica si la llave primaria es autoincremental (por defecto, Eloquent asume 'true')
    public $incrementing = false;

    // Atributos que se pueden asignar de manera masiva
    protected $fillable = [
        // Agrega aquí los nombres de las columnas de la tabla que desees permitir que se llenen masivamente
        'nombre',
        'apellidos',
        'cedula',
        'correo',
        'contraseña',
        'fecha_nacimiento',
        'telefono',
        'fotografia',
        'idrol',
        'estatus',
    ];

    public $timestamps = false;

    // Atributos que deben ser ocultos en las respuestas JSON
    protected $hidden = [
        'contraseña',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($Usuarios) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Usuarios', 'Se ha insertado un registro en Usuarioss con Cédula: ' . $Usuarios->cedula));
        });

        static::updated(function ($Usuarios) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Usuarios', 'Se ha editado un registro en Usuarios con Cédula: ' . $Usuarios->cedula));
        });

    }

    // Mutador para encriptar la contraseña antes de guardarla en la base de datos
    public function setContraseñaAttribute($value)
    {
        $this->attributes['contraseña'] = Hash::make($value);
    }

    public function ingresos()
    {
        return $this->hasMany(Ingresos::class, 'correo');
    }

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'idrol');
    }
    // Resto del código del modelo...

    public function getAuthIdentifierName()
    {
        return 'correo'; 
    }

    public function getAuthIdentifier()
    {
        return $this->correo; 
    }

    public function getAuthPassword()
    {
        return $this->contraseña; // Retorna la contraseña del usuario encriptada.
    }

    public function getRememberToken()
    {
        return null; 
    }

    public function setRememberToken($value)
    {

    }

    public function getRememberTokenName()
    {
        return null; 
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Events\MovimientoEvent;

class bitacora extends Model
{
    use HasFactory;
    protected $table = 'tbl_bitacora';
    protected $primaryKey = 'id_bitacora';
    public $incrementing = true;

    protected $fillable = [
        'num_tiquete',
        'usuario',
        'comentario',
        'fecha_hora',
        'fotografia'
    ];

    public $timestamps = false;
    // Resto del código del modelo...

    public static function boot()
    {
        parent::boot();

        static::created(function ($Bitacora) {
            $user = auth()->user();
            event(new MovimientoEvent($user,'Insertar en Bitacora', 'Se ha insertado un registro en Bitacora con id_bitacora: ' . $Bitacora->id_bitacora));
        });

        static::updated(function ($Bitacora) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Editar en Bitacora', 'Se ha editado un registro en en Bitacora con id_bitacora: ' .$Bitacora->id_bitacora));
        });

        static::deleted(function ($Bitacora) {
            $user = auth()->user();
            event(new MovimientoEvent($user, 'Eliminar en Bitacora', 'Se ha eliminado un registro en en Bitacora con id_bitacora: ' . $Bitacora->id_bitacora));
        });
    }
}

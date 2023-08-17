<?php

namespace App\Listeners;

use App\Events\MovimientoEvent;
use App\Models\Movimientos;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MovimientoListener
{ 
    
   
    /**
     * Create the event listener.
     */
    public function __construct()
    {
       
    }

    /**
     * Handle the event.
     */ 
    public function handle(MovimientoEvent $event)
    {

        $user=$event->user;
        // Registrar el movimiento en la tabla "movimientos"
        Movimientos::create([
            'usuario' => $user->correo,
            'fecha_hora_mov' => now(),
            'tipo_mov' => $event->tipo_mov,
            'detalle' => $event->detalle
            
        ]);
    }
}

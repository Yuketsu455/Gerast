<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Entrada en la Bitácora</title>
    @include('link')
    <style>
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('menu')
    <div class="container mt-5 offset-md-1">
       <h2>Agregar Entrada en la Bitácora</h2>
       @if(Session::has('error'))
       <div class="alert alert-danger">
           {{ Session::get('error') }}
       </div>
   @endif

   @if(Session::has('success'))
       <div class="alert alert-success">
           {{ Session::get('success') }}
       </div>
   @endif


        <form method="POST" action="{{route ('bitacora.store')}}">
            @csrf
            <div class="form-group col-md-6 offset-md-3">
                <label for="num_caso">Número de Caso:</label>
                <select class="form-control" id="num_caso" name="num_caso">
                    @foreach($numerosTiquete as $numeroTiquete)
                        <option value="{{ $numeroTiquete }}">{{ $numeroTiquete }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6 offset-md-3">
                <label for="usuario_revisor">Usuario que revisa el equipo:</label>
                <input type="text" class="form-control" id="usuario_revisor" name="usuario_revisor" value="{{auth()->user()->correo}}" readonly>
            </div>

            <div class="form-group col-md-6 offset-md-3">
                <label for="comentario">Línea de Comentario:</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="3" placeholder="Ingrese el comentario"></textarea>
            </div>

            <div class="form-group col-md-6 offset-md-3">
                <label for="fecha_hora">Fecha y Hora del Comentario:</label>
                <input type="text" id="fecha_hora" name="fecha_hora" readonly>
                
            <script>
                // Script para establecer el formato de hora "dd-MM-yyyy HH:mm:ss"
                document.addEventListener('DOMContentLoaded', function() {
                    const fechaHoraInput = document.getElementById('fecha_hora');

                    // Obtenemos la fecha y hora actual
                    const fechaHoraActual = new Date();

                    // Formateamos la fecha y hora en el formato deseado
                    const dia = String(fechaHoraActual.getDate()).padStart(2, '0');
                    const mes = String(fechaHoraActual.getMonth() + 1).padStart(2, '0');
                    const anio = fechaHoraActual.getFullYear();
                    const hora = String(fechaHoraActual.getHours()).padStart(2, '0');
                    const minutos = String(fechaHoraActual.getMinutes()).padStart(2, '0');
                    const segundos = String(fechaHoraActual.getSeconds()).padStart(2, '0');

                    // Concatenamos los valores para formar la fecha y hora en el formato deseado
                    const fechaHoraFormateada = `${anio}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;

                    // Asignamos el valor formateado al campo de entrada (readonly)
                    fechaHoraInput.value = fechaHoraFormateada;
                });
            </script>
             </div>

            <div class="form-group col-md-6 offset-md-3">
                <label for="fotografia_equipo">Fotografía del Equipo:</label>
                <input type="file" class="form-control-file" id="fotografia_equipo" name="fotografia_equipo">
            </div>

            <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Agregar Entrada</button>
            <br></br>
                <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Bitacora_index') }}" role="button">Volver al Inicio</a>
        </form>
    </div>

    @include('fooder')
</body>
</html>
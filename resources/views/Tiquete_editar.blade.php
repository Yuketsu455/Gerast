<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Tiquetes</title>
    @include('link')
    <style>
        /* Aplica el estilo del fondo */
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
@include('menu')
<div class="container">
    <div class="form-container">
        <h2 class="text-center mb-4">Editar Tiquete</h2>
        <form method="POST" action="{{ route('tiquete.update', $tiquete->num_caso) }}">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="num_caso">Número de Caso:</label>
                <input type="text" class="form-control" id="num_caso" name="num_caso" value="{{ $tiquete->num_caso }}" readonly>
            </div>

            <div class="form-group">
                <label for="tipo_equipo">Tipo de Equipo:</label>
                <input type="text" class="form-control" id="tipo_equipo" name="tipo_equipo" value="{{ $tiquete->tipo_equipo }}" required>
            </div>

            <div class="form-group">
                <label for="usuario_receptor">Usuario que recibe el equipo:</label>
                <input type="text" class="form-control" id="usuario_receptor" name="usuario_receptor" value="{{ auth()->user()->correo }}" readonly>
            </div>

            <div class="form-group">
                <label for="marca">Marca:</label>
                <input type="text" class="form-control" id="marca" name="marca" value="{{ $tiquete->marca }}" required>
            </div>

            <div class="form-group">
                <label for="modelo">Modelo:</label>
                <input type="text" class="form-control" id="modelo" name="modelo" value="{{ $tiquete->modelo }}" required>
            </div>

            <div class="form-group">
                <label for="serie">Serie:</label>
                <input type="text" class="form-control" id="serie" name="serie" value="{{ $tiquete->serie }}" required>
            </div>

            <div class="form-group">
                <label for="cargador">Cargador:</label>
                <select class="form-control" id="cargador" name="cargador" required>
                    <option value="No" {{ $tiquete->cargador === 'No' ? 'selected' : '' }}>No</option>
                    <option value="Si" {{ $tiquete->cargador === 'Si' ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label for="garantia">Garantía:</label>
                <select class="form-control" id="garantia" name="garantia" required>
                    <option value="No" {{ $tiquete->garantia === 'No' ? 'selected' : '' }}>No</option>
                    <option value="Si" {{ $tiquete->garantia === 'Si' ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fecha_ingreso">Fecha y hora de ingreso:</label>
                <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="{{ $tiquete->fecha_ingreso }}" readonly>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const fechaHoraInput = document.getElementById('fecha_ingreso');
                        const fechaHoraActual = new Date();
                        const anio = fechaHoraActual.getFullYear();
                        const mes = String(fechaHoraActual.getMonth() + 1).padStart(2, '0');
                        const dia = String(fechaHoraActual.getDate()).padStart(2, '0');
                        const hora = String(fechaHoraActual.getHours()).padStart(2, '0');
                        const minutos = String(fechaHoraActual.getMinutes()).padStart(2, '0');
                        const segundos = String(fechaHoraActual.getSeconds()).padStart(2, '0');
                        const fechaHoraFormateada = `${anio}-${mes}-${dia} ${hora}:${minutos}:${segundos}`;
                        fechaHoraInput.value = fechaHoraFormateada;
                    });
                </script>
            </div>

            <div class="form-group">
                <label for="prioridad">Prioridad:</label>
                <select class="form-control" id="prioridad" name="prioridad" required>
                    <option value="Alta" {{ $tiquete->prioridad === 'Alta' ? 'selected' : '' }}>Alta</option>
                    <option value="Media" {{ $tiquete->prioridad === 'Media' ? 'selected' : '' }}>Media</option>
                    <option value="Baja" {{ $tiquete->prioridad === 'Baja' ? 'selected' : '' }}>Baja</option>
                </select>
            </div>

            <div class="form-group">
                <label for="estado">Estado del tiquete:</label>
                <select class="form-control" id="estado" name="estado" required>
                    <option value="Recibido" {{ $tiquete->estado_tiquete === 'Recibido' ? 'selected' : '' }}>Recibido</option>
                    <option value="En Revision" {{ $tiquete->estado_tiquete === 'En Revision' ? 'selected' : '' }}>En Revisión</option>
                    <option value="Confirmacion pendiente" {{ $tiquete->estado_tiquete === 'Confirmacion pendiente' ? 'selected' : '' }}>Confirmación Pendiente</option>
                    <option value="En centro de servicio" {{ $tiquete->estado_tiquete === 'En centro de servicio' ? 'selected' : '' }}>En Centro de Servicio</option>
                    <option value="Listo" {{ $tiquete->estado_tiquete === 'Listo' ? 'selected' : '' }}>Listo</option>
                    <option value="Entregado" {{ $tiquete->estado_tiquete=== 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="Cerrado" {{ $tiquete->estado_tiquete === 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fotografias">Fotografías del equipo:</label>
                <input type="file" class="form-control-file" id="fotografias" name="fotografias" multiple>
            </div>

            <div class="form-group">
               <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Actualizar</button>
               <a class="btn btn-secondary col-md-6 offset-md-3 mt-2" href="{{ route('Tiquete_index') }}" role="button">Volver al Inicio</a>
            </div>
        </form>
    </div>
</div>
@include('fooder')
</body>
</html>
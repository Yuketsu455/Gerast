<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Tiquete</title>
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
        <div class="row justify-content-center">
            <div class="col-md-8 form-container">
                <h2 class="text-center">Agregar Tiquete</h2>

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

                <form method="POST" action="{{ route('tiquete.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="num_caso">Número de Caso:</label>
                        <input type="text" class="form-control" id="num_caso" name="num_caso" placeholder="Ingrese el número de caso" onkeypress="return soloNumeros(event,'num_caso')" onpaste="return validarPegadoNumero(event,'num_caso')" required pattern="[0-9]+" title="Solo se permiten números" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-num_caso" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tipo_equipo">Tipo de Equipo:</label>
                        <input type="text" class="form-control" id="tipo_equipo" name="tipo_equipo" onkeypress="return soloLetras(event,'tipo_equipo')" onpaste="return validarContenido(event,'tipo_equipo')" placeholder="Ingrese el tipo de equipo" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-tipo_equipo" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_cliente">Identificación del Cliente:</label>
                        <select name="id_cliente" id="id_cliente" class="form-control">
                            @foreach ($Clientes as $cliente)
                                <option value="{{ $cliente->cedula }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="usuario_receptor">Usuario que recibe el equipo:</label>
                        <input type="text" class="form-control" id="usuario_receptor" name="usuario_receptor" value="{{ auth()->user()->correo }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="marca">Marca:</label>
                        <input type="text" class="form-control" id="marca" name="marca" placeholder="Ingrese la marca del equipo" required>
                    </div>

                    <div class="form-group">
                        <label for="modelo">Modelo:</label>
                        <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Ingrese el modelo del equipo" required>
                    </div>

                    <div class="form-group">
                        <label for="serie">Serie:</label>
                        <input type="text" class="form-control" id="serie" name="serie" placeholder="Ingrese el número de serie del equipo" required>
                    </div>

                    <div class="form-group">
                        <label for="cargador">Cargador:</label>
                        <select class="form-control" id="cargador" name="cargador" required>
                            <option value="No">No</option>
                            <option value="Si">Sí</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="garantia">Garantía:</label>
                        <select class="form-control" id="garantia" name="garantia" required>
                            <option value="No">No</option>
                            <option value="Si">Sí</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fecha_ingreso">Fecha y hora de ingreso:</label>
                        <input type="text" class="form-control" id="fecha_ingreso" name="fecha_ingreso" readonly>
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
                            <option value="Alta">Alta</option>
                            <option value="Media">Media</option>
                            <option value="Baja">Baja</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="estado">Estado del tiquete:</label>
                        <select class="form-control" id="estado" name="estado" required>
                            <option value="Recibido">Recibido</option>
                            <option value="En Revision">En Revisión</option>
                            <option value="Confirmacion Pendiente">Confirmación Pendiente</option>
                            <option value="Servicio">En Centro de Servicio</option>
                            <option value="Listo">Listo</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Cerrado">Cerrado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fotografias">Fotografías del equipo:</label>
                        <input type="file" class="form-control-file" id="fotografias" name="fotografias" multiple>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Agregar</button>
                    <br><br>
                    <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Tiquete_index') }}" role="button">Volver al Inicio</a>
                </form>
            </div>
        </div>
    </div>
    @include('fooder')
</body>
</html>
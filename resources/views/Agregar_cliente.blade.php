<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    @include('link')
    <link rel="stylesheet" href="ruta-a-tu-archivo.css"> <!-- Enlace al archivo CSS externo -->
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
                <center><h2>Agregar Cliente</h2></center>

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

                <form method="POST" action="{{ route('cliente.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" onkeypress="return soloLetras(event,'nombre')" onpaste="return validarContenido(event,'nombre')" placeholder="Ingrese el nombre" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-nombre" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el nombre.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellido:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" onkeypress="return soloLetras(event,'apellidos')" onpaste="return validarContenido(event,'apellidos')" placeholder="Ingrese el apellido del cliente" title="Solo se permiten letras" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-apellidos" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten letras y espacios en el apellido.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cedula">Número de cédula:</label>
                        <input type="text" class="form-control" id="cedula" name="cedula" onkeypress="return soloNumeros(event,'cedula')" onpaste="return validarPegadoNumero(event,'cedula')" placeholder="Ingrese el número de cédula del cliente" required pattern="[0-9]+" title="Solo se permiten números" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-cedula" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="correo">Correo electrónico @:</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese el correo electrónico del cliente" required>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" onkeypress="return soloNumeros(event,'telefono')" onpaste="return validarPegadoNumero(event,'telefono')" placeholder="Ingrese el número de teléfono del cliente" required pattern="[0-9]+" title="Solo se permiten números" required>
                        <div class="alert alert-danger mt-2" id="mensaje-error-telefono" style="display: none;">
                            <i class="bi bi-exclamation-triangle"></i> Solo se permiten números.
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary col-md-6 offset-md-3">Agregar</button>
                    <br><br>
                    <a class="btn btn-secondary col-md-6 offset-md-3" href="{{ route('Cliente_index') }}" role="button">Volver al Inicio</a>
                </form>
            </div>
        </div>
    </div>
    @include('fooder')
</body>
</html>
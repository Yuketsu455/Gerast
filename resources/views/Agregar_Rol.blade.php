<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Agregar Rol</title>
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
    <div class="container mt-5 mx-auto col-md-6 form-container">
        <div class="text-center">
            <h2>Agregar Rol</h2>
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
        </div>
        <form method="POST" action="{{ route('roles.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del rol" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Agregar</button>
                <br></br>
                <a class="btn btn-secondary mt-2" href="{{ route('Roles_index') }}" role="button">Volver al Inicio</a>
            </div>
        </form>
    </div>
    @include('fooder')
</body>
</html>
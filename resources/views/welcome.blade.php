<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Página de Inicio</title>
    @include('link')
</head>
<body>
    @include('menu')
    
    <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">¡Bienvenido a Satellite!</h1>
            <p class="lead">Aquí encontrarás un sistema de gestión de equipos en revisión.</p>
            
            @auth
                <p>Bienvenido, {{ auth()->user()->nombre }}</p>
            @else
                <p>Por favor, inicia sesión para acceder al contenido</p>
            @endauth
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
    
    @include('fooder')
</body>
</html>
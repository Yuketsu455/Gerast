<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Acerca de</title>
    @include('link')
</head>
<body>
@include('menu')
<div class="container">
    <h2 class="text-center">Acerca de</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Información del sistema</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>Acrónimo del sistema:</strong> G.E.R.A.S.T</li>
                <li class="list-group-item"><strong>Nombre del sistema:</strong> Gestión de Equipos en Revisión para el Área de Soporte Técnico</li>
                <li class="list-group-item"><strong>Versión:</strong> 1.7.0</li>
                <li class="list-group-item"><strong>Fecha de versión:</strong> 08/08/2023</li>
                <li class="list-group-item"><strong>Propietario:</strong> Satellite</li>
                <li class="list-group-item"><strong>Desarrolladores:</strong> Jaikel Gomez Bryan, Kevin Soto Morales</li>
                <li class="list-group-item"><strong>Lenguaje de programación:</strong> PHP</li>
                <li class="list-group-item"><strong>Framework utilizado:</strong>Laravel</li>
                <li class="list-group-item"><strong>Información adicional:</strong>En esta version encontrara todo lo necesario, tanto funciones, validaciones y demas completamente funcionales</li>
            </ul>
        </div>
    </div>
    @include('fooder')
</div>
</body>
</html>
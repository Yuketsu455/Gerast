<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ingresos</title>
    
    @include('link')
</head>
<body>
@include('menu')
<div class="container mt-5">
    <h2 class="text-center mb-4">Registros de Ingresos</h2>
    <form action="{{ route('ingresos.filter') }}" method="POST" class="mb-4">
        @csrf
        <div class="row">
            <div class="col-md-3" >
                <div class="form-group">
                    <label for="fecha_inicio">Fecha de inicio:</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" @if(request()->filled('fecha_inicio')) value="{{ request()->input('fecha_inicio') }}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="fecha_fin">Fecha de fin:</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" @if(request()->filled('fecha_fin')) value="{{ request()->input('fecha_fin') }}" @endif>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="correo">Usuario (correo):</label>
                    <input type="email" name="correo" id="correo" class="form-control" @if(request()->filled('correo')) value="{{ request()->input('correo') }}" @endif>
                </div>
            </div>
            <div class="col-md-3">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center ">
                <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i>Filtrar</button>
                <a href="{{ route('Ingresos_index') }}" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro</a>
                <a href="{{ route('pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin'), 'correo' => request('correo')]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i> Generar Reporte</a>
            </div>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table table-dark table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Código Movimiento</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora de Ingreso</th>
                    <th>Fecha y Hora de Salida</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $ingresos as $ingreso)
                <tr>
                    <td>{{ $ingreso->cod_movimiento }}</td>
                    <td>{{ $ingreso->usuario }}</td>
                    <td>{{ $ingreso->fecha_hora_ingreso }}</td>
                    <td>{{ $ingreso->fecha_hora_salida ?? 'No registrado' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination justify-content-center mt-4">
        <ul class="pagination">
            <li class="page-item {{ $ingresos->currentPage() == 1 ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $ingresos->appends(request()->except('page'))->url(1) }}">Primera</a>
            </li>
            @for ($page = max(1, $ingresos->currentPage() - 2); $page <= min($ingresos->lastPage(), $ingresos->currentPage() + 2); $page++)
                <li class="page-item {{ $page == $ingresos->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $ingresos->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                </li>
            @endfor
            <li class="page-item {{ $ingresos->currentPage() == $ingresos->lastPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $ingresos->appends(request()->except('page'))->url($ingresos->lastPage()) }}">Última</a>
            </li>
        </ul>
    </div>
</div>
@include('fooder')
</body>
</html>
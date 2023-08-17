<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Movimientos</title>
    @include('link')
</head>
<body>
    @include('menu')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Movimientos</h2>
        <!-- Formulario de filtrado -->
        <form action="{{ route('movimientos.filter') }}" method="POST" class="mb-4">
            @csrf
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha de inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fecha_fin">Fecha de fin:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="correo">Usuario (correo):</label>
                        <input type="email" name="correo" id="correo" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tipo_movimiento">Tipo de movimiento:</label>
                        <select name="tipo_movimiento" id="tipo_movimiento" class="form-control">
                            <option value="">Todos</option>
                            <option value="Insertar">Insertar</option>
                            <option value="Editar">Editar</option>
                            <option value="Eliminar">Eliminar</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-filter"></i>Filtrar</button>
                    <a href="{{ route('Movimientos_index') }}" class="btn btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Limpiar filtro</a>
                    <a href="{{ route('movimientos.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin'), 'correo' => request('correo'), 'tipo_movimiento' => request('tipo_movimiento')]) }}" class="btn btn-success"><i class="bi bi-printer-fill"></i>Generar Reporte</a>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Código Movimiento</th>
                        <th>Usuario</th>
                        <th>Fecha y Hora de Movimiento</th>
                        <th>Tipo de Movimiento</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($movimientos as $movimiento)
                        <tr>
                            <td>{{ $movimiento->cod_movimiento }}</td>
                            <td>{{ $movimiento->usuario }}</td>
                            <td>{{ $movimiento->fecha_hora_mov }}</td>
                            <td>{{ $movimiento->tipo_mov }}</td>
                            <td>{{ $movimiento->detalle }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination justify-content-center mt-4">
            <ul class="pagination">
                <li class="page-item {{ $movimientos->currentPage() == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $movimientos->appends(request()->except('page'))->url(1) }}">Primera</a>
                </li>
                @for ($page = max(1, $movimientos->currentPage() - 2); $page <= min($movimientos->lastPage(), $movimientos->currentPage() + 2); $page++)
                    <li class="page-item {{ $page == $movimientos->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $movimientos->appends(request()->except('page'))->url($page) }}">{{ $page }}</a>
                    </li>
                @endfor
                <li class="page-item {{ $movimientos->currentPage() == $movimientos->lastPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $movimientos->appends(request()->except('page'))->url($movimientos->lastPage()) }}">Última</a>
                </li>
            </ul>
        </div>
    </div>
    @include('fooder')
</body>
</html>
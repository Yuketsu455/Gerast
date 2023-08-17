<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ route('welcome') }}">Satellite</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php $user = auth()->user(); ?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Inicio
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('welcome') }}">Regresar a Inicio</a>
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="dropdown-item" type="submit">Cerrar sesión</button>
                    </form> 
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mantenimiento
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    $mantenimientoPermitted = $user && $user->rol && $user->rol->permisos()->whereIn('idOperacion', [4, 8, 12])->exists();
                    if ($mantenimientoPermitted) {
                        if ($user->rol->permisos()->where('idOperacion', 4)->exists()) {
                            echo '<a class="dropdown-item" href="' . route('Usuario_index') . '">Mantenimiento Usuarios</a>';
                        }
                        if ($user->rol->permisos()->where('idOperacion', 8)->exists()) {
                            echo '<a class="dropdown-item" href="' . route('Cliente_index') . '">Mantenimiento Clientes</a>';
                        }
                        if ($user->rol->permisos()->where('idOperacion', 12)->exists()) {
                            echo '<a class="dropdown-item" href="' . route('Tiquete_index') . '">Mantenimiento Tiquetes</a>';
                        }
                    }
                    ?>
                </div>
            </li>
            <li class="nav-item">
                <?php if ($user && $user->rol && $user->rol->permisos()->where('idOperacion', 18)->exists()): ?>
                    <a class="nav-link" href="{{ route('Roles_index') }}">Roles</a>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <?php if ($user && $user->rol && $user->rol->permisos()->where('idOperacion', 14)->exists()): ?>
                    <a class="nav-link" href="{{ route('Bitacora_index') }}">Bitacora</a>
                <?php endif; ?>
            </li>
            <li class="nav-item dropdown">
                <?php if ($user && $user->rol && ($user->rol->permisos()->where('idOperacion', 19)->exists() || $user->rol->permisos()->where('idOperacion', 20)->exists())): ?>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Reportes
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if ($user->rol->permisos()->where('idOperacion', 19)->exists()): ?>
                            <a class="dropdown-item" href="{{ route('Ingresos_index') }}">Seguridad</a>
                        <?php endif; ?>
                        <?php if ($user->rol->permisos()->where('idOperacion', 20)->exists()): ?>
                            <a class="dropdown-item" href="{{ route('Movimientos_index') }}">Movimientos</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('Acercade') }}">Acerca de</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Manual.pdf" target="_blank">Ayuda</a>
            </li>
        </ul>
    </div>
</nav>
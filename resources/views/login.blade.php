<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @include('link')
    <style>
        body {
            background-color: #333; /* Color de fondo oscuro */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-container h3 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
            color: #000000; /* Texto blanco */
        }

        .login-container form {
            margin-top: 20px;
        }

        .login-container .form-label {
            font-weight: bold;
        }

        .login-container .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Color azul brillante para el botón */
            border-color: #007bff;
        }

        .login-container .btn-primary:hover {
            background-color: #0056b3; /* Cambio de color al pasar el cursor */
            border-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-container">
                <h3>Bienvenido a Gerast</h3> <!-- Mensaje de bienvenida -->
                
                @if(session('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session('error') }}
                    </div>
                @endif

                <h2>Iniciar sesión</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico @:</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="contraseña">Contraseña:</label>
                        <div class="input-group">
                            <input type="password" name="contraseña" id="password" class="form-control" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility()">
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>
                    
                    @error('correo')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
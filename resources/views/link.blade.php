<style>
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding: 0;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a, .pagination li span {
        display: block;
        padding: 5px 10px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }

    .pagination li.active span {
        background-color: #007bff;
        color: #fff;
    }

    body {
        font-family: Arial, sans-serif;
    }
    
    .jumbotron {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .jumbotron h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .jumbotron p.lead {
        font-size: 18px;
        margin-bottom: 20px;
    }

    .alert {
        margin-top: 20px;
        border-radius: 5px;
    }  
      .container {
        padding: 20px;
    }
    .card {
        border: none;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .card-title {
        font-size: 24px;
        margin-bottom: 20px;
    }
    .list-group-item {
        border: none;
    }
    .list-group-item strong {
        font-weight: 600;
    }

    body {
            background-color: #f2f2f2;
        }
        /* Estilo para el formulario */
        .container {
            margin-top: 50px;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
        }
        
        .alert {
            margin-top: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }
</style>

<script>
   function soloLetras(event, campo) {
    var charCode = event.which || event.keyCode;
    var charStr = String.fromCharCode(charCode);
    var pattern = /^[A-Za-z\s]+$/; // Expresión regular para validar letras y espacios
    var mensajeErrorId = "mensaje-error-" + campo;
    var inputField = document.getElementById(campo);

    if (!pattern.test(charStr)) {
        inputField.classList.add("input-error");
        document.getElementById(mensajeErrorId).style.display = "block";
        return false;
    } else {
        inputField.classList.remove("input-error");
        document.getElementById(mensajeErrorId).style.display = "none";
        return true;
    }
}
</script>

<script>
  function validarContenido(event, campo) {
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedText = clipboardData.getData('text');
    var pattern = /^[A-Za-z\s]+$/; // Expresión regular para validar letras y espacios
    var mensajeErrorId = "mensaje-error-" + campo;
    var inputField = document.getElementById(campo);

    if (!pattern.test(pastedText)) {
        inputField.classList.add("input-error");
        document.getElementById(mensajeErrorId).style.display = "block";
        setTimeout(function() {
            inputField.classList.remove("input-error");
            document.getElementById(mensajeErrorId).style.display = "none";
        }, 3000); // Ocultar el mensaje después de 3 segundos
        return false;
    }
    return true;
}
    </script>

<script>
function soloNumeros(event, campo) {
    var charCode = event.which || event.keyCode;
    var charStr = String.fromCharCode(charCode);
    var pattern = /^\d+$/; // Expresión regular para validar números
    var mensajeErrorId = "mensaje-error-" + campo;
    var inputField = document.getElementById(campo);

    if (!pattern.test(charStr)) {
        inputField.classList.add("input-error");
        document.getElementById(mensajeErrorId).style.display = "block";
        return false;
    } else {
        inputField.classList.remove("input-error");
        document.getElementById(mensajeErrorId).style.display = "none";
        return true;
    }
}
    </script>

<script>
function validarPegadoNumero(event, campo) {
    var clipboardData = event.clipboardData || window.clipboardData;
    var pastedText = clipboardData.getData('text');
    var pattern = /^\d+$/; // Expresión regular para validar números

    if (!pattern.test(pastedText)) {
        event.preventDefault();
        document.getElementById("mensaje-error-" + campo).style.display = "block";
        return false;
    }
    return true;
}
    </script>

<script>
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.classList.remove('bi-eye-slash');
        eyeIcon.classList.add('bi-eye');
    } else {
        passwordInput.type = 'password';
        eyeIcon.classList.remove('bi-eye');
        eyeIcon.classList.add('bi-eye-slash');
    }
}
</script>

<script>
    function validarCorreo() {
        var correoInput = document.getElementById("correo");
        var mensajeError = document.getElementById("mensaje-error-correo");
    
        var correo = correoInput.value.trim();
        var correoValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo);
    
        if (!correoValido) {
            mensajeError.style.display = "block";
            correoInput.setCustomValidity("Correo electrónico inválido");
        } else {
            mensajeError.style.display = "none";
            correoInput.setCustomValidity("");
        }
    }
    </script>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.0/css/bootstrap.min.css">
<!-- Agrega el ícono de ojo de Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
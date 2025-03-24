<?php
session_start(); // Esto debe estar al inicio
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="./assets/login/login.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Iniciar Sesion</h2>
    <form action="index.php?controlador=User&accion=verificarLogin" method="post">
        <div class="form-group">
            <input
                type="email"
                class="form-control"
                name="email"
                placeholder="Email: "
                required="required">
        </div>
        <div class="form-group">
            <input
                type="password"
                class="form-control"
                name="password"
                placeholder="Contraseña: "
                required="required">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Entrar" name="submit">
            <a href="index.php?controlador=User&accion=register" class="btn btn-primary">Registrarse</a>
        </div>

    </form>
</div>
<?php if (isset($_SESSION["error"])) {
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '" . $_SESSION["error"] . "'
            });
        });
    </script>";
    unset($_SESSION["error"]); 
}
?>
</body>
</html>
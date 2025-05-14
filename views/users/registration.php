<!DOCTYPE html>
<html lang="en">
<head>
<link href="./assets/login/register.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container">
    <h2>REGISTRO</h2>
    <form
        action="index.php?controlador=User&accion=verificarRegistro"
        method="post">
        <div class="form-group">
            <input
                type="text"
                class="form-control"
                name="fullname"
                placeholder="Nombre: "
                required="required">
        </div>
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
        <div class="form-group">
            <input
                type="password"
                class="form-control"
                name="repeat_password"
                placeholder="Repite la contraseña: "
                required="required">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Enviar" name="submit">
            <a href="index.php?controlador=User&accion=login" class="btn btn-primary">Volver</a>
        </div>
    </form>
</div>
<?php
session_start();
if (isset($_SESSION['error']) && $_SESSION['error'] == 'email_existente') {
    echo '<script>
        Swal.fire({
            icon: "error",
            title: "Correo ya registrado",
            text: "El correo electrónico ya existe. Intenta con otro."
        });
    </script>';
    unset($_SESSION['error']); // Limpiar error para evitar que se repita la alerta
}
?>

</body>
</html>
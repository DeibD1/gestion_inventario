<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Acceso Denegado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/denegacion/style.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
</head>
<body>

    <?php require_once "views/shared/navbar.php"; ?>

    <div class="message-box">
        <h1>Acceso Denegado</h1>
        <p>No tienes permisos para acceder a esta sección.</p>
    </div>

    <?php require_once "views/shared/footer.php"; ?>

</body>
</html>

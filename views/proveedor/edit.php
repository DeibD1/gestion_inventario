<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/navbar/styleedit.css" rel="stylesheet">
</head>
<body>

    <?php require_once "views/shared/navbar.php"; ?>

    <div class="container">
        <h1 class="text-center text-light mb-4">Actualizar Proveedor</h1>

        <form action="index.php?controlador=Proveedor&accion=update" method="post" 
              class="card p-4 shadow-lg bg-opacity-10 border-primary rounded mx-auto" style="max-width: 35rem; background-color: rgba(255, 255, 255, 0.1);">
              
            <input type="hidden" name="id_proveedor" value="<?=  $data['proveedor']['id']?>">

            <label for="nombre" class="form-label text-light mt-3">Nombre</label>
            <input type="text" required class="form-control bg-dark text-light border-secondary rounded-3"
                   placeholder="Nombre del proveedor" name="nombre" value="<?= $data['proveedor']['nombre']?>">

            <label for="telefono" class="form-label text-light mt-3">Teléfono</label>
            <input type="text" required class="form-control bg-dark text-light border-secondary rounded-3"
                   placeholder="Teléfono del proveedor" name="telefono" value="<?= $data['proveedor']['telefono']?>">

            <label for="direccion" class="form-label text-light mt-3">Dirección</label>
            <input type="text" required class="form-control bg-dark text-light border-secondary rounded-3"
                   placeholder="Dirección del proveedor" name="direccion" value="<?= $data['proveedor']['direccion']?>">

            <label for="email" class="form-label text-light mt-3">Email</label>
            <input type="email" required class="form-control bg-dark text-light border-secondary rounded-3"
                   placeholder="Email del proveedor" name="email" value="<?= $data['proveedor']['email']?>">

            <div class="text-center mt-4">
                <input type="submit" class="btn btn-primary w-100 rounded-pill" value="Actualizar Proveedor">
            </div>
        </form>
    </div>

    <?php require_once "views/shared/footer.php"; ?>

</body>
</html>
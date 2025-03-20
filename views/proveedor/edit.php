<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/proveedores/edit/style.css" rel="stylesheet">
</head>
<body>

    <?php require_once "views/shared/navbar.php"; ?>

    <form action="index.php?controlador=Proveedor&accion=update" method="post" class="form-container">        
        <h1 class="text-center my-5 titulo_register"><?= $data['titulo'] ?></h1>
        <div class="card border-primary mb-3 mx-auto" style="max-width: 40rem;" >
            <div class="card-body">
                <input type="hidden" name="id_proveedor" value="<?= $data['proveedor']['id']?>">

                <label for="nombre" class="form-label mt-4">Nombre</label>
                <input type="text" required class="form-control" placeholder="Nombre del proveedor" name="nombre" value="<?= $data['proveedor']['nombre']?>">

                <label for="telefono" class="form-label mt-4">Teléfono</label>
                <input type="text" required class="form-control" placeholder="Teléfono del proveedor" name="telefono" value="<?= $data['proveedor']['telefono']?>">

                <label for="direccion" class="form-label mt-4">Dirección</label>
                <input type="text" required class="form-control" placeholder="Dirección del proveedor" name="direccion" value="<?= $data['proveedor']['direccion']?>">

                <label for="email" class="form-label mt-4">Email</label>
                <input type="email" required class="form-control" placeholder="Email del proveedor" name="email" value="<?= $data['proveedor']['email']?>">

                <div class="text-center">
                    <input type="submit" class="btn btn-primary mt-4 py-3 boton-envio" value="Actualizar">
                </div>
            </div>
        </div>
    </form>


    <?php require_once "views/shared/footer.php"; ?>

</body>
</html>

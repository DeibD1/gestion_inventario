<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/productos/index/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

<div class="container">
    <h1 class="titulo"><?= $data['titulo'] ?></h1>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th colspan="3" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['ventas'] as $venta) { ?>
                    <tr class="lista">
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['total'] ?></td>
                        <td>
                            <button class="btn btn-primary">
                                Generar Factura
                            </button>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <button class="btn btn-danger">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once "views/shared/footer.php"; ?>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

<div>
        <h1 class="text-center my-5"><?= $data["titulo"] ?></h1>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Direccion</th>
                    <th>Email</th>
                    <th colspan="2" style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['proveedores'] as $proveedor) {?>
                        <tr>
                            <td><?= $proveedor['nombre']?></td>
                            <td><?= $proveedor['telefono']?></td>
                            <td><?= $proveedor['direccion']?></td>
                            <td><?= $proveedor['email']?></td>
                            <td>
                                <?= "<a href='index.php?controlador=Proveedor&accion=edit&idProveedor=" . $proveedor['id'] . "' class='btn btn-warning me-3'>Editar</a>" ?>
                                </td>
                                <td>
                                <?= "<a href='index.php?controlador=Proveedor&accion=delete&idProveedor=" . $proveedor['id'] . "' class='btn btn-danger'>Eliminar</a>" ?>
                            </td>
                        </tr>
                    <?php }?>
            </tbody>
        </table>
    </div>

<?php require_once "views/shared/footer.php"; ?>
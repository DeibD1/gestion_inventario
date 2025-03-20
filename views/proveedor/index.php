<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/proveedores/index/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

<div class="container">
    <h1 class="titulo"><?= $data['titulo'] ?></h1>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Email</th>
                    <th colspan="2" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['proveedores'] as $proveedor) { ?>
                    <tr class="lista">
                        <td><?= $proveedor['nombre'] ?></td>
                        <td><?= $proveedor['telefono'] ?></td>
                        <td><?= $proveedor['direccion'] ?></td>
                        <td><?= $proveedor['email'] ?></td>
                        <td>
                            <a href="index.php?controlador=Proveedor&accion=edit&idProveedor=<?= $proveedor['id'] ?>" 
                               class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="confirmDelete(<?= $proveedor['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
            </div>
            <div class="modal-body mensaje-eliminar" style="color: black;">
                ¿Estás seguro de que deseas eliminar este proveedor?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    function confirmDelete(idProveedor) {
        let confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = `index.php?controlador=Proveedor&accion=delete&idProveedor=${idProveedor}`;
        
        let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once "views/shared/footer.php"; ?>

</body>
</html>

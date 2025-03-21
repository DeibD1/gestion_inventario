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
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Neto</th>
                    <th>Proveedor</th>
                    <th colspan="3" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['productos'] as $producto) { ?>
                    <tr class="lista">
                        <td><?= $producto['nombre'] ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td><?= $producto['precio_neto'] ?></td>
                        <td><?= $producto['proveedor'] ?></td>
                        <td>
                            <button class="btn btn-primary" data-producto='<?= json_encode($producto, JSON_HEX_APOS | JSON_HEX_QUOT) ?>' onclick="showProductDetails(this)">
                                Ver más
                            </button>
                        </td>
                        <td>
                            <a href="index.php?controlador=Proveedor&accion=edit&idProveedor=<?= $proveedor['id'] ?>" 
                               class="btn btn-warning">Editar</a>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="confirmDelete(<?= $producto['id'] ?>)">Eliminar</button>
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
                    ¿Estás seguro de que deseas eliminar este producto?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Detalles del Producto</h5>
                </div>
                <div class="modal-body" style="color: black;">
                    <p><strong>Nombre:</strong> <span id="productName"></span></p>
                    <p><strong>Descripción:</strong> <span id="productDescription"></span></p>
                    <p><strong>Cantidad:</strong> <span id="productQuantity"></span></p>
                    <p><strong>Precio Neto:</strong> <span id="productNetPrice"></span></p>
                    <p><strong>Precio Venta:</strong> <span id="productSalePrice"></span></p>
                    <p><strong>Fecha de Ingreso:</strong> <span id="productDate"></span></p>
                    <p><strong>Proveedor:</strong> <span id="productSupplier"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
<script>
    function confirmDelete(idProducto) {
        let confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = `index.php?controlador=Producto&accion=delete&idProducto=${idProducto}`;
        
        let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
    function showProductDetails(button) {
        let producto = JSON.parse(button.getAttribute('data-producto'));

        document.getElementById("productName").innerText = producto.nombre;
        document.getElementById("productDescription").innerText = producto.descripcion;
        document.getElementById("productQuantity").innerText = producto.cantidad;
        document.getElementById("productNetPrice").innerText = `$${producto.precio_neto.toLocaleString()}`;
        document.getElementById("productSalePrice").innerText = `$${producto.precio_venta.toLocaleString()}`;
        document.getElementById("productDate").innerText = producto.fecha_ingreso;
        document.getElementById("productSupplier").innerText = producto.proveedor;

        let modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
        modal.show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once "views/shared/footer.php"; ?>

</body>
</html>

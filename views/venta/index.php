<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/ventas/index/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

<div class="container">
    <h1 class="titulo"><?= $data['titulo'] ?></h1>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th colspan="3" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['ventas'] as $venta) { ?>
                    <tr class="lista">
                        <td><?= $venta['id'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['total'] ?></td>
                        <td>
                        <a href="index.php?controlador=Venta&accion=verInformacionVenta&idVenta=<?= $venta['id'] ?>" class="btn btn-primary">Ver Mas</a>
                        </td>
                        <td>
                            <a href="index.php?controlador=Venta&accion=generarFactura&idVenta=<?= $venta['id'] ?>" class="btn btn-warning">Generar Factura</a>
                        </td>
                        <td>
                            <button class="btn btn-danger" onclick="confirmDelete(<?= $venta['id'] ?>)">Eliminar</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="infoVentaModal" tabindex="-1" aria-labelledby="infoVentaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="infoVentaModalLabel">Información de la Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            
            <div class="modal-body">
                <h4><strong>Fecha:</strong> <?= $ventaSeleccionada['fecha'] ?></h4>

                <h4 class="titulo-productos"><strong>Productos Vendidos:</strong> </h4>
                <table class="table table-bordered">
                <thead class="cabecera-tabla">
                    <tr>
                    <th>Producto</th>
                    <th>Precio Unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['productosVendidos'] as $producto): ?>
                    <tr>
                        <td><?= $producto['nombre'] ?></td>
                        <td>$<?= number_format($producto['precio_venta'], 0, ',', '.') ?></td>
                        <td><?= $producto['cantidad_vendida'] ?></td>
                        <td>$<?= number_format($producto['precio_venta'] * $producto['cantidad_vendida'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <td colspan="2">TOTAL</td>
                    <td colspan="2">$<?= number_format($ventaSeleccionada['total'], 0, ',', '.') ?></td>
                </tbody>
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"> 
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                </div>
                <div class="modal-body mensaje-eliminar" style="color: black;">
                    ¿Estás seguro de que deseas eliminar esta venta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Aceptar</a>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<?php require_once "views/shared/footer.php"; ?>
    <?php if (isset($data['infoVenta']) && $data['infoVenta'] === true): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalVenta = new bootstrap.Modal(document.getElementById('infoVentaModal'));
        modalVenta.show();
    });
    </script>
<?php endif; ?>

<?php if (!empty($data['idVenta'])) : ?>
    <script>
        window.onload = function() {
            window.open('index.php?controlador=Venta&accion=generarFactura&idVenta=<?= $data['idVenta'] ?>', '_blank');

            const url = new URL(window.location);
            url.searchParams.delete('idVenta');
            window.history.replaceState({}, document.title, url);
        }
    </script>
<?php endif; ?>

<script>
    function confirmDelete(idVenta) {
        let confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        confirmDeleteBtn.href = `index.php?controlador=Venta&accion=delete&idVenta=${idVenta}`;
        
        let modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }
</script>

</body>
</html>
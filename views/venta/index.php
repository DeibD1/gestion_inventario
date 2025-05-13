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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   
<?php require_once "views/shared/navbar.php"; ?>
<div class="container">

    <div>
        <h4 class="titulo mb-3">Filtrar Ventas</h4>
        <form method="post" action="index.php?controlador=Venta&accion=filtrarVentas" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label for="estadoVenta" class="form-label">Estado</label>
                <select class="form-select" id="estadoVenta" name="estadoVenta">
                    <option value="1" <?= isset($filtros['estadoVenta']) && $filtros['estadoVenta'] == '1' ? 'selected' : '' ?>>Activa</option>
                    <option value="0" <?= isset($filtros['estadoVenta']) && $filtros['estadoVenta'] == '0' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="totalMin" class="form-label">Total mínimo</label>
                <input type="number" class="form-control" id="totalMin" name="totalMin" placeholder="Ej: 10000" min="0"
                    value="<?= isset($filtros['totalMin']) ? htmlspecialchars($filtros['totalMin']) : '' ?>">
            </div>
            <div class="col-md-2">
                <label for="totalMax" class="form-label">Total máximo</label>
                <input type="number" class="form-control" id="totalMax" name="totalMax" placeholder="Ej: 50000" min="0"
                    value="<?= isset($filtros['totalMax']) ? htmlspecialchars($filtros['totalMax']) : '' ?>">
            </div>
            <div class="col-md-2">
                <label for="fechaInicio" class="form-label">Fecha inicio</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio"
                    value="<?= isset($filtros['fechaInicio']) ? htmlspecialchars($filtros['fechaInicio']) : '' ?>">
            </div>
            <div class="col-md-2">
                <label for="fechaFin" class="form-label">Fecha fin</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin"
                    value="<?= isset($filtros['fechaFin']) ? htmlspecialchars($filtros['fechaFin']) : '' ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-success w-100">Aplicar filtros</button>
            </div>
        </form>
    </div>

    <h1 class="titulo my-5"><?= $data['titulo'] ?></h1>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th colspan="3" class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['ventas'] as $venta) { ?>
                    <tr class="lista">
                        <td><?= $venta['id'] ?></td>
                        <td><?= $venta['fecha'] ?></td>
                        <td><?= $venta['total'] ?></td>
                        <td><?= $venta['activo'] == 1 ? 'Activa' : 'Cancelada' ?></td>
                        <td>
                        <a href="index.php?controlador=Venta&accion=verInformacionVenta&idVenta=<?= $venta['id'] ?>" class="btn btn-primary">Ver Mas</a>
                        </td>
                        <td>
                            <a href="index.php?controlador=Venta&accion=generarFactura&idVenta=<?= $venta['id'] ?>" class="btn btn-warning">Generar Factura</a>
                        </td>
                        <td>
                            <?php if ($venta['activo'] == 1): ?>
                                <button class="btn btn-danger" onclick="confirmDelete(<?= $venta['id'] ?>)">Cancelar</button>
                            <?php else: ?>
                                <button class="btn btn-secondary" disabled>Cancelada</button>
                            <?php endif; ?>
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
                <h4><strong>Estado:</strong> <?= $ventaSeleccionada['activo'] == 1 ? 'Activa' : 'Cancelada' ?></h4>

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
                    ¿Estás seguro de que deseas cancelar esta venta?
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

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="index.php?controlador=Venta&accion=filtrarVentas"]');
        form.addEventListener('submit', function (event) {
            const totalMinEl = document.getElementById('totalMin');
            const totalMaxEl = document.getElementById('totalMax');
            const fechaInicioEl = document.getElementById('fechaInicio');
            const fechaFinEl = document.getElementById('fechaFin');
            const estadoVentaEl = document.getElementById('estadoVenta');

            const totalMin = totalMinEl.value.trim();
            const totalMax = totalMaxEl.value.trim();
            const fechaInicio = fechaInicioEl.value.trim();
            const fechaFin = fechaFinEl.value.trim();
            const estadoVenta = estadoVentaEl.value.trim();

            const totalFieldsFilled = totalMin !== '' && totalMax !== '';
            const dateFieldsFilled = fechaInicio !== '' && fechaFin !== '';
            const estadoFilled = estadoVenta !== ''; 

            const fechasValidas = !dateFieldsFilled || new Date(fechaInicio) <= new Date(fechaFin);
            const totalMinVal = parseFloat(totalMin);
            const totalMaxVal = parseFloat(totalMax);
            const totalesValidos = !totalFieldsFilled || totalMinVal <= totalMaxVal;

            const allFieldsEmpty = totalMin === '' && totalMax === '' && fechaInicio === '' && fechaFin === '' && !estadoFilled;

            if (allFieldsEmpty) {
                event.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'Sin filtros',
                    text: 'No se ha especificado ningún filtro.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            if (!(totalFieldsFilled || dateFieldsFilled || estadoFilled)) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Filtros incompletos',
                    text: 'Debes completar al menos los campos de total mínimo y máximo, los de fecha inicio y fin, o seleccionar un estado.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            if (dateFieldsFilled && !fechasValidas) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Rango de fechas inválido',
                    text: 'La fecha de inicio no puede ser mayor que la fecha fin.',
                    confirmButtonText: 'Aceptar'
                });
                return;
            }

            if (totalFieldsFilled && !totalesValidos) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Totales inválidos',
                    text: 'El monto mínimo no puede ser mayor que el monto máximo.',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });



</script>

</body>
</html>
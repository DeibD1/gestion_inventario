<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/ventas/reporteVenta/reporteStyle.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
   
<?php require_once "views/shared/navbar.php"; ?>
<div class="container">

    <div>
        <h4 class="titulo-reporte text-center mb-4"><?= $data['titulo'] ?></h4>

    <div class="contenedor-formulario">
        <form method="post" action="index.php?controlador=Venta&accion=generarReportePDF" class="formulario-reporte row gx-4 gy-3 align-items-end">
            <div class="col-md-3">
                <label for="estadoVenta" class="form-label">Estado</label>
                <select class="form-select" id="estadoVenta" name="estadoVenta">
                    <option value="" <?= !isset($filtros['estadoVenta']) || $filtros['estadoVenta'] === '' ? 'selected' : '' ?>>Todos</option>
                    <option value="1" <?= isset($filtros['estadoVenta']) && $filtros['estadoVenta'] == '1' ? 'selected' : '' ?>>Activa</option>
                    <option value="0" <?= isset($filtros['estadoVenta']) && $filtros['estadoVenta'] == '0' ? 'selected' : '' ?>>Cancelada</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="fechaInicio" class="form-label">Fecha inicio</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio"
                    value="<?= isset($filtros['fechaInicio']) ? htmlspecialchars($filtros['fechaInicio']) : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="fechaFin" class="form-label">Fecha fin</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin"
                    value="<?= isset($filtros['fechaFin']) ? htmlspecialchars($filtros['fechaFin']) : '' ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100">Generar Reporte</button>
            </div>

            <div class="col-md-3 offset-md-9">
                <button type="button" id="btnLimpiarFiltrosReporte" class="btn btn-secondary w-100">Limpiar filtros</button>
            </div>
        </form>
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
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form[action="index.php?controlador=Venta&accion=generarReportePDF"]');
        form.addEventListener('submit', function (event) {
            const fechaInicioEl = document.getElementById('fechaInicio');
            const fechaFinEl = document.getElementById('fechaFin');

            const fechaInicio = fechaInicioEl.value.trim();
            const fechaFin = fechaFinEl.value.trim();

            const dateFieldsFilled = fechaInicio !== '' && fechaFin !== '';

            const fechasValidas = !dateFieldsFilled || new Date(fechaInicio) <= new Date(fechaFin);

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

        });
    });

    document.getElementById('btnLimpiarFiltrosReporte').addEventListener('click', function () {
        const form = this.closest('form');
        form.reset();
        form.querySelector('#estadoVenta').value = '';
    });

</script>

</body>
</html>
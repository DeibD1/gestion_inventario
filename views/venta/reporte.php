<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            margin: 40px;
            color: #2c3e50;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 22px;
            margin: 0;
        }

        .company-details {
            font-size: 12px;
            color: #555;
        }

        .report-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #34495e;
            margin: 30px 0 5px;
        }

        .report-subtitle {
            text-align: center;
            font-size: 13px;
            color: #7f8c8d;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            background-color: #34495e;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 12px;
        }

        td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ccc;
            font-size: 12px;
        }

        tr:nth-child(even) {
            background-color: #f4f6f7;
        }

        .total-row {
            background-color: #ecf0f1;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #7f8c8d;
        }

        .no-data {
            text-align: center;
            color: #c0392b;
            font-weight: bold;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1><?php echo $nombreEmpresa; ?></h1>
        <div class="company-details">
            <p>NIT: <?php echo $NIT; ?></p>
            <p>Dirección: <?php echo $direccion; ?> | Tel: <?php echo $telefono; ?></p>
        </div>
    </div>

    <div class="report-title">REPORTE DE VENTAS</div>
    <div class="report-subtitle">Fecha de generación: <?php echo $fechaGeneracion; ?></div>

    <?php if (isset($ventasReporte) && count($ventasReporte) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sumaTotal = 0;
                    foreach ($ventasReporte as $venta): 
                        $totalNumerico = (float) str_replace(['$', '.'], ['', ''], $venta['total']);
                        $sumaTotal += $totalNumerico;
                ?>
                    <tr>
                        <td><?php echo $venta['id']; ?></td>
                        <td><?php echo $venta['fecha']; ?></td>
                        <td><?php echo $venta['total']; ?></td>
                        <td><?php echo isset($venta['estado']) ? $venta['estado'] : ($venta['activo'] == 1 ? 'Activa' : 'Cancelada'); ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr class="total-row">
                    <td colspan="2" style="text-align: right;">Total General:</td>
                    <td colspan="2"><?php echo '$' . number_format($sumaTotal, 0, ',', '.'); ?></td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <p>Número total de ventas: <?php echo count($ventasReporte); ?></p>
            <p>Reporte generado el <?php echo $fechaGeneracion; ?></p>
        </div>
    <?php else: ?>
        <div class="no-data">
            <p>No se encontraron ventas que coincidan con los criterios de búsqueda.</p>
        </div>
    <?php endif; ?>
</body>
</html>

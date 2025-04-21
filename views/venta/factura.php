<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            padding: 30px;
            max-width: 600px;
            margin: auto;
            background: #fff;
            color: #333;
        }

        .titulo {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .datos-empresa, .datos-cliente {
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .productos {
            margin-top: 30px;
        }

        .productos table {
            width: 100%;
            border-collapse: collapse;
        }

        .productos th, .productos td {
            text-align: left;
            padding: 4px 0;
        }

        .productos th {
            font-weight: bold;
            border-bottom: 1px solid #aaa;
        }

        .final-venta td{
            border-top: 1px solid #aaa;
        }

        .resumen {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .resumen-tabla {
            width: 250px;
        }

        .resumen-tabla div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="titulo">Factura de Venta</div>

<div class="datos-empresa">
    <strong>Empresa:</strong> <?= $data['nombreEmpresa'] ?><br>
    <strong>NIT:</strong> <?= $data['NIT'] ?><br>
    <strong>Dirección:</strong> <?= $data['direccion'] ?><br>
    <strong>Teléfono:</strong> <?= $data['telefono'] ?>
</div>

<div class="datos-cliente">
    <strong>Factura N°:</strong> <?= $ventaSeleccionada['id'] ?><br>
    <strong>Fecha:</strong> <?= date('Y-m-d', strtotime($ventaSeleccionada['fecha'])) ?><br>
</div>

<div class="productos">
    <table>
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Nombre</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productosVendidos as $producto): ?>
                <tr>
                    <td><?= $producto['id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['cantidad_vendida'] ?></td>
                    <td>$<?= number_format($producto['precio_venta'], 0, '', '.') ?></td>
                    <td>$<?= number_format($producto['cantidad_vendida'] * $producto['precio_venta'], 0, '', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="final-venta">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td><strong>Subtotal:</strong></td>
                <td>$<?= number_format($ventaSeleccionada['total'], 0, '', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td><strong>Descuento:</strong></td>
                <td>$<?= number_format(0, 0, '', '.') ?></td>
            </tr>
            <tr>
                <td colspan="3"></td>
                <td><strong>Total:</strong></td>
                <td><strong>$<?= number_format($ventaSeleccionada['total'], 0, '', '.') ?></strong></td>
            </tr>
        </tfoot>
    </table>
</div>

<div class="footer">
    Gracias por su compra<br>
    Esta factura es válida como comprobante fiscal
</div>

</body>
</html>

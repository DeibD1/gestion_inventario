<?php 
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .container {
            width: 100%;
            max-width: 1200px; 
            margin: auto;
            text-align: center;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            max-width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th, .table td {
            border: 1px solid #000;
            padding: 12px;
            text-align: center;
            font-size: 14px;
            word-wrap: break-word;
        }

        .table th {
            background-color: rgb(60, 174, 60);
            color: white;
            font-weight: bold;
            vertical-align: middle; 
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="titulo"><?= $data['titulo'] ?></h1>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Precio Neto</th>
                    <th>Precio Venta</th>
                    <th>Proveedor</th>
                    <th>Fecha de Ingreso</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['productos'] as $producto) { ?>
                    <tr class="lista">
                        <td><?= $producto['nombre'] ?></td>
                        <td><?= $producto['cantidad'] ?></td>
                        <td><?= $producto['precio_neto'] ?></td>
                        <td><?= $producto['precio_venta'] ?></td>
                        <td><?= $producto['proveedor'] ?></td>
                        <td><?= $producto['fecha_ingreso'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php 
$html=ob_get_clean();
require_once './lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options); 

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');
// $dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("reporte_productos.pdf", array("Attachment" => true));

?>

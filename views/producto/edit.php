<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/proveedores/insert/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

<form action="index.php?controlador=Producto&accion=update" method="post" >
    <h1 class="text-center my-5 titulo_register"><?= $data['titulo'] ?></h1>
    <div class="card border-primary mb-3 mx-auto" style="max-width: 40rem;" >
        <div class="card-body">

            <input type="hidden" name="id_producto" value="<?= $data['producto']['id']?>">

            <label for="nombre" class="form-label mt-4">Nombre</label>
            <input type="text" required class="form-control" placeholder="Nombre del producto" name="nombre" value="<?= $data['producto']['nombre']?>">
            
            <label for="descripcion" class="form-label mt-4">Descripcion</label>
            <input type="text" required class="form-control" placeholder="Descripcion del producto" name="descripcion" value="<?= $data['producto']['descripcion']?>">

            <label for="cantidad" class="form-label mt-4">Cantidad</label>
            <input type="number" min="1" max="1000" step="1" required class="form-control" placeholder="Cantidad del producto" name="cantidad" value="<?= $data['producto']['cantidad']?>">

            <label for="precio_neto" class="form-label mt-4">Precio Neto</label>
            <input type="number" min="1" max="100000000" required class="form-control" placeholder="Precio neto del producto" name="precio_neto" value="<?= $data['producto']['precio_neto']?>">

            <label for="precio_venta" class="form-label mt-4">Precio Venta</label>
            <input type="number" min="1" required class="form-control" placeholder="Precio Venta del producto" name="precio_venta" value="<?= $data['producto']['precio_venta']?>">
            
            
            <label for="fecha_ingreso" class="form-label mt-4">Fecha de Ingreso</label>
            <input type="date" required class="form-control" placeholder="Fecha de ingreso del producto" name="fecha_ingreso" value="<?= $data['producto']['fecha_ingreso']?>" min="2025-01-01" max="2035-12-31">

            <label for="proveedor" class="form-label mt-4">Proveedor</label>
            <select class="form-control" required name="proveedor">
                <?php foreach ($data['proveedores'] as $item) { 
                    $selected = ($item['id'] == $data['producto']['id_proveedor']) ? 'selected' : ''; 
                ?>
                    <option value="<?= $item['id'] ?>" <?= $selected ?>><?= $item['nombre'] ?></option>
                <?php } ?>
            </select>


            <input type="submit" class="btn btn-primary mt-4 py-3 boton-envio" value="Registrar">
        </div>
    </div>
</form>

<?php require_once "views/shared/footer.php"; ?>
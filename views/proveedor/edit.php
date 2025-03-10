<?php require_once "views/shared/header.php"; ?>


<form action="index.php?controlador=Proveedor&accion=update" method="post" > 
    <h1 class="text-center my-5"><?= $data['titulo'] ?></h1>
    <div class="card border-primary mb-3 mx-auto" style="max-width: 40rem;" >
        <div class="card-body">

            <input type="hidden" name="id_proveedor" value="<?=  $data['proveedor']['id']?>">

            <label for="nombre" class="form-label mt-4">Nombre</label>
            <input type="text" required class="form-control" placeholder="Nombre del proveedor" name="nombre" value="<?= $data['proveedor']['nombre']?>">
            
            <label for="telefono" class="form-label mt-4">Telefono</label>
            <input type="text" required class="form-control" placeholder="Telefono del proveedor" name="telefono" value="<?= $data['proveedor']['telefono']?>">

            <label for="direccion" class="form-label mt-4">Direccion</label>
            <input type="text" required class="form-control" placeholder="Direccion del proveedor" name="direccion" value="<?= $data['proveedor']['direccion']?>">

            <label for="email" class="form-label mt-4">Email</label>
            <input type="email" required class="form-control" placeholder="Email del proveedor" name="email" value="<?= $data['proveedor']['email']?>">

            <input type="submit" class="btn btn-primary mt-4" value="Editar Proveedor">
        </div>
    </div>
</form>

<?php require_once "views/shared/footer.php"; ?>
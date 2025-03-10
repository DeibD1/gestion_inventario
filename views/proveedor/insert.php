<?php require_once "views/shared/header.php"; ?>

<form action="index.php?controlador=Proveedor&accion=store" method="post" >

    <h1 class="text-center my-5"><?= $data['titulo'] ?></h1>
    <div class="card border-primary mb-3 mx-auto" style="max-width: 40rem;" >
        <div class="card-body">
            <label for="nombre" class="form-label mt-4">Nombre</label>
            <input type="text" required class="form-control" placeholder="Nombre del proveedor" name="nombre">
            
            <label for="telefono" class="form-label mt-4">Telefono</label>
            <input type="text" required class="form-control" placeholder="Telefono del proveedor" name="telefono">

            <label for="direccion" class="form-label mt-4">Direccion</label>
            <input type="text" required class="form-control" placeholder="Direccion del proveedor" name="direccion">

            <label for="email" class="form-label mt-4">Email</label>
            <input type="email" required class="form-control" placeholder="Email del proveedor" name="email">


            <input type="submit" class="btn btn-primary mt-4" value="Registrar">
        </div>
    </div>
    
</form>

<?php require_once "views/shared/footer.php"; ?>
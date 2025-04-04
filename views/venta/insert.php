<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion-inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="./assets/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/navbar/style.css" rel="stylesheet">
    <link href="./assets/ventas/insert/style.css" rel="stylesheet">
</head>
<body>
    
<?php require_once "views/shared/navbar.php"; ?>

    <div class="container">
      <div class="form-venta">

        <header class="titulo">
            <h1><?= $data['titulo'] ?></h1>
        </header>

        <div class="campo">
          <label for="fechaVenta">Fecha de la venta:</label>
          <input type="date" id="fechaVenta" />
        </div>

        <div class="campo">
          <label for="buscarProducto">Producto vendido:</label>
          <div class="buscador">
            <input
              type="text"
              id="buscarProducto"
              placeholder="Ingrese nombre del producto..."
              onkeyup="mostrarSugerencias()"
            />
            <div id="sugerencias" class="sugerencias"></div>
          </div>
        </div>

        <div class="campo">
          <label for="cantidadProducto">Cantidad:</label>
          <input
            type="number"
            id="cantidadProducto"
            min="1"
            placeholder="Ej: 100"
            value="1"
          />
        </div>

        <div class="campo">
          <button class="agregar-btn" onclick="agregarProducto()">
            AGREGAR PRODUCTO
          </button>
        </div>

        <div class="campo">
          <h2>Productos de la Venta</h2>
          <table class="tabla-ventas">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Fecha de Venta</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="cuerpoTabla"></tbody>
          </table>
        </div>

        <div class="campo">
          <button class="guardar-btn" onclick="registrarVenta()">
            REGISTRAR VENTA
          </button>
        </div>
      </div>
    </div>

    <script>
      const productosSugeridos = [
        "Camiseta",
        "Pantalón",
        "Zapatos",
        "Gorra",
        "Chaqueta",
        "Medias",
        "Bufanda",
        "Reloj",
      ];

      function mostrarSugerencias() {
        const input = document
          .getElementById("buscarProducto")
          .value.toLowerCase();
        const sugerenciasDiv = document.getElementById("sugerencias");
        sugerenciasDiv.innerHTML = "";

        if (input === "") {
          sugerenciasDiv.style.display = "none";
          return;
        }

        const sugerenciasFiltradas = productosSugeridos.filter((producto) =>
          producto.toLowerCase().includes(input)
        );

        if (sugerenciasFiltradas.length === 0) {
          sugerenciasDiv.style.display = "none";
          return;
        }

        sugerenciasFiltradas.forEach((producto) => {
          const div = document.createElement("div");
          div.classList.add("sugerencia-item");
          div.textContent = producto;
          div.onclick = () => {
            document.getElementById("buscarProducto").value = producto;
            sugerenciasDiv.innerHTML = "";
            sugerenciasDiv.style.display = "none";
          };
          sugerenciasDiv.appendChild(div);
        });

        sugerenciasDiv.style.display = "block";
      }

      function agregarProducto() {
        const producto = document.getElementById("buscarProducto").value.trim();
        const fecha = document.getElementById("fechaVenta").value;
        const cantidad = document.getElementById("cantidadProducto").value;
        const precio = 1000;

        if (!producto || !fecha || !cantidad || !precio) {
          alert(
            "Por favor, completa todos los campos antes de agregar un producto."
          );
          return;
        }

        const cuerpoTabla = document.getElementById("cuerpoTabla");
        const fila = document.createElement("tr");

        fila.innerHTML = `
        <td>${producto}</td>
        <td>${fecha}</td>
        <td>${cantidad}</td>
        <td>${precio}</td>
        <td><button class="btn-delete" onclick="eliminarFila(this)">Eliminar</button></td>
      `;

        cuerpoTabla.appendChild(fila);

        document.getElementById("buscarProducto").value = "";
        document.getElementById("cantidadProducto").value = "1";
        document.getElementById("sugerencias").style.display = "none";
      }

      function eliminarFila(boton) {
        const fila = boton.parentElement.parentElement;
        fila.remove();
      }

      function registrarVenta() {
        const filas = document.querySelectorAll("#cuerpoTabla tr");
        if (filas.length === 0) {
          alert("No hay productos en la venta.");
          return;
        }

        const venta = [];
        filas.forEach((fila) => {
          const celdas = fila.querySelectorAll("td");
          venta.push({
            producto: celdas[0].textContent,
            fecha: celdas[1].textContent,
            cantidad: celdas[2].textContent,
            precio: celdas[3].textContent,
          });
        });

        console.log("Venta registrada:", venta);
        alert("¡Venta registrada con éxito!");

        document.getElementById("cuerpoTabla").innerHTML = "";
      }
    </script>


<?php require_once "views/shared/footer.php"; ?>
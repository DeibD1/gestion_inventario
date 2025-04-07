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
      <form id="formVenta" action="index.php?controlador=Venta&accion=store" method="post" class="form-venta">
        <header class="titulo">
            <h1><?= $data['titulo'] ?></h1>
        </header>

        <div class="campo">
          <label for="fechaVenta">Fecha de la venta:</label>
          <input type="date" id="fechaVenta"  min="2025-01-01" max="2035-12-31"/>
        </div>

        <div class="campo">
          <label for="buscarProducto">Producto vendido:</label>
          <div class="buscador">
          <input
            type="text"
            id="buscarProducto"
            placeholder="Ingrese nombre del producto..."
            onkeyup="mostrarSugerencias()"
            onfocus="mostrarSugerencias(true)"
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
        <button type="button" class="agregar-btn" onclick="agregarProducto()">
          AGREGAR PRODUCTO
        </button>
        </div>

        <div class="campo">
          <h2>Productos de la Venta</h2>
          <table class="tabla-ventas">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Eliminar</th>
              </tr>
            </thead>
            <tbody id="cuerpoTabla"></tbody>
            <tfoot>
              <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2" id="totalVenta"><strong>$0</strong></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <div class="campo">
          <button  type="button" class="guardar-btn" onclick="registrarVenta()">
            REGISTRAR VENTA
          </button>
        </div>
      </form>
    </div>

    <script>
      const productosSugeridos = <?= json_encode($data['nombre_productos'], JSON_UNESCAPED_UNICODE); ?>;
      const productosInfo = <?= json_encode($data['productos'], JSON_UNESCAPED_UNICODE); ?>;


      function actualizarTotal() {
        const filas = document.querySelectorAll("#cuerpoTabla tr");
        let total = 0;

        filas.forEach(fila => {
          const cantidad = parseInt(fila.children[1].textContent);
          const precio = parseInt(fila.children[2].getAttribute("data-precio"));
          total += cantidad * precio;
        });

        const totalFormateado = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(total);
        document.getElementById("totalVenta").innerHTML = `<strong>${totalFormateado}</strong>`;
      }

      function mostrarSugerencias(forzado = false) {
        const input = document.getElementById("buscarProducto").value.toLowerCase();
        const sugerenciasDiv = document.getElementById("sugerencias");
        sugerenciasDiv.innerHTML = "";

        if (input === "") {
          sugerenciasDiv.innerHTML = "";
          productosSugeridos.forEach((producto) => {
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
          return;
        }

        const sugerenciasFiltradas = input === "" && forzado
          ? productosSugeridos 
          : productosSugeridos.filter((producto) =>
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
        const nombreProducto = document.getElementById("buscarProducto").value.trim();
        const cantidad = parseInt(document.getElementById("cantidadProducto").value);

        const productoSeleccionado = productosInfo.find(p => p.nombre === nombreProducto);

        if (!productoSeleccionado) {
          alert("Producto no válido o no encontrado.");
          return;
        }

        const stockDisponible = parseInt(productoSeleccionado.cantidad);
        const id = productoSeleccionado.id;
        const precio = productoSeleccionado.precio_venta;
        const precioFormateado = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(precio);

        if (!nombreProducto || !cantidad || !precio) {
          alert("Por favor, completa todos los campos antes de agregar un producto.");
          return;
        }

        if (cantidad > stockDisponible) {
          alert(`No hay suficiente stock disponible. Solo hay ${stockDisponible} unidades en bodega.`);
          return;
        }

        const filas = document.querySelectorAll("#cuerpoTabla tr");
        for (let fila of filas) {
          const idFila = fila.querySelector("td").getAttribute("data-id");
          if (idFila === id.toString()) {
            alert("Este producto ya ha sido agregado a la venta.");
            document.getElementById("buscarProducto").value = "";
            document.getElementById("cantidadProducto").value = "1";
            document.getElementById("sugerencias").style.display = "none";
            return;
          }
        }

        const cuerpoTabla = document.getElementById("cuerpoTabla");
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td data-id="${id}">${nombreProducto}</td>
            <td>${cantidad}</td>
            <td data-precio="${precio}">${precioFormateado}</td>
            <td><button class="btn-delete" onclick="eliminarFila(this)">Eliminar</button></td>
        `;

        cuerpoTabla.appendChild(fila);

        document.getElementById("buscarProducto").value = "";
        document.getElementById("cantidadProducto").value = "1";
        document.getElementById("sugerencias").style.display = "none";
        actualizarTotal();
      }


      function eliminarFila(boton) {
        const fila = boton.parentElement.parentElement;
        fila.remove();
        actualizarTotal();
      }

      function registrarVenta() {
        const filas = document.querySelectorAll("#cuerpoTabla tr");
        const fecha = document.getElementById("fechaVenta").value;
        const form = document.getElementById("formVenta");
        const pieTabla = document.getElementById("totalVenta").textContent.trim();
        const totalVenta = parseInt(pieTabla.replace(/[^\d]/g, ""), 10);

        if (filas.length === 0) {
          alert("No hay productos en la venta.");
          return;
        }
        if (!fecha) {
          alert("Debes seleccionar la fecha de la venta.");
          return;
        }

        document.querySelectorAll(".input-dinamico").forEach(el => el.remove());

        const inputFecha = document.createElement("input");
        inputFecha.type = "hidden";
        inputFecha.name = "fecha";
        inputFecha.value = fecha;
        inputFecha.classList.add("input-dinamico");
        form.appendChild(inputFecha);

        filas.forEach((fila, index) => {
          const celdas = fila.querySelectorAll("td");

          const idProducto = celdas[0].getAttribute("data-id");
          const nombre = celdas[0].textContent;
          const cantidad = celdas[1].textContent;
          const precio = celdas[2].getAttribute("data-precio");

          ["id", "producto", "cantidad", "precio"].forEach((campo, i) => {
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = `productos[${index}][${campo}]`;
            input.value = [idProducto, nombre, cantidad, precio][i];
            input.classList.add("input-dinamico");
            form.appendChild(input);
          });
        });

        const inputTotalVenta = document.createElement("input");
        inputTotalVenta.type = "hidden";
        inputTotalVenta.name = "totalVenta";
        inputTotalVenta.value = totalVenta;
        inputTotalVenta.classList.add("input-dinamico");
        form.appendChild(inputTotalVenta);

        form.submit();
      }
    </script>


<?php require_once "views/shared/footer.php"; ?>
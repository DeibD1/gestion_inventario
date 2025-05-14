<nav class="navbar">
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        <div class="logo">Software Gestión de Inventario</div>
        <a href="index.php?controlador=User&accion=login" class="logout">Cerrar Sesión</a>
    </nav>

    <div class="sidebar" id="sidebar">
        <ul class="menu">

            <li onclick="toggleSubmenu(1)">📋 Inventario <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-1">
                    <li><a href="index.php?controlador=Producto&accion=index">📜 Lista de Productos</a></li>
                    <li><a href="index.php?controlador=Producto&accion=insert">✍ Registrar Productos</a></li>
                    <li><a href="index.php?controlador=Producto&accion=reporte">📑 Reporte de Inventario</a></li>
                </ul>
            </li>

            <li onclick="toggleSubmenu(2)">🚚 Proveedores <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-2">
                    <li><a href="index.php?controlador=Proveedor&accion=index">📜 Lista de Proveedores</a></li>
                    <li><a href="index.php?controlador=Proveedor&accion=insert">✍ Registrar Proveedor</a></li>
                </ul>
            </li>

            <li onclick="toggleSubmenu(3)">📄 Facturación <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-3">
                    <li><a href="index.php?controlador=Venta&accion=index">📂 Historial de Ventas</a></li>
                    <li><a href="index.php?controlador=Venta&accion=insert">📝 Registrar Venta</a></li>
                    <li><a href="#">💰 Cuentas por Cobrar</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <script>
        function toggleMenu() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
        }

        function closeMenu() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.remove("show");
            overlay.classList.remove("show");
            const submenus = document.querySelectorAll(".submenu");
            submenus.forEach(submenu => submenu.style.display = "none");
        }

        function toggleSubmenu(id) {
            const submenu = document.getElementById(`submenu-${id}`);
            if (submenu) {
                const submenus = document.querySelectorAll(".submenu");
                submenus.forEach(sm => {
                    if (sm !== submenu) sm.style.display = "none";
                });
                submenu.style.display = submenu.style.display === "block" ? "none" : "block";
            }
        }
    </script>
    <div class="mx-md-3">
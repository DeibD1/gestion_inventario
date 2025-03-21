<nav class="navbar">
        <div class="menu-toggle" onclick="toggleMenu()">☰</div>
        <div class="logo">Software Gestión de Inventario</div>
        <a href="index.php?controlador=User&accion=login" class="logout">Cerrar Sesión</a>
    </nav>

    <!-- Menú Lateral -->
    <div class="sidebar" id="sidebar">
        <ul class="menu">
            <li onclick="toggleSubmenu(1)">📋 Inventario <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-1">
                    <li><a href="index.php?controlador=Producto&accion=index">📦 Productos</a></li>
                    <li onclick="toggleSubmenu(12)">📊 Reportes <span class="arrow">▶</span>
                        <ul class="submenu" id="submenu-12">
                            <li><a href="#">Ventas</a></li>
                            <li><a href="#">Compras</a></li>
                            <li><a href="#">Stock</a></li>
                        </ul>
                    </li>
                    <li onclick="toggleSubmenu(13)">🔄 Movimientos <span class="arrow">▶</span>
                        <ul class="submenu" id="submenu-13">
                            <li><a href="#">Entradas</a></li>
                            <li><a href="#">Salidas</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li onclick="toggleSubmenu(2)">🚚 Proveedores <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-2">
                    <li><a href="index.php?controlador=Proveedor&accion=index">📜 Lista de Proveedores</a></li>
                    <li><a href="index.php?controlador=Proveedor&accion=insert">✍ Registrar Proveedor</a></li>
                    <li><a href="#">📑 Historial de Compras</a></li>
                </ul>
            </li>

            <li onclick="toggleSubmenu(3)">📄 Facturación <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-3">
                    <li><a href="#">📝 Nueva Factura</a></li>
                    <li><a href="#">📂 Historial de Ventas</a></li>
                    <li><a href="#">💰 Cuentas por Cobrar</a></li>
                </ul>
            </li>

            <li onclick="toggleSubmenu(4)">⚙ Configuración <span class="arrow">▶</span>
                <ul class="submenu" id="submenu-4">
                    <li><a href="#">👤 Usuarios</a></li>
                    <li><a href="#">🔒 Permisos</a></li>
                    <li><a href="#">⚙ Ajustes del Sistema</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <!-- Overlay (fondo oscuro) -->
    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <script>
        // Función para abrir/cerrar el menú lateral
        function toggleMenu() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.toggle("show");
            overlay.classList.toggle("show");
        }

        // Función para cerrar el menú lateral
        function closeMenu() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");
            sidebar.classList.remove("show");
            overlay.classList.remove("show");

            // Cerrar todos los submenús al cerrar el menú lateral
            const submenus = document.querySelectorAll(".submenu");
            submenus.forEach(submenu => submenu.style.display = "none");
        }

        // Función para abrir/cerrar submenús
        function toggleSubmenu(id) {
            const submenu = document.getElementById(`submenu-${id}`);
            if (submenu) {
                // Cerrar cualquier otro submenú abierto antes de abrir uno nuevo
                const submenus = document.querySelectorAll(".submenu");
                submenus.forEach(sm => {
                    if (sm !== submenu) sm.style.display = "none";
                });

                // Alternar la visibilidad del submenú seleccionado
                submenu.style.display = submenu.style.display === "block" ? "none" : "block";
            }
        }
    </script>
    <div class="mx-md-3">
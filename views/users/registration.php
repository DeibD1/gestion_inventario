<?php require_once "views/shared/navbar.php"; ?>
<link href="../../assets/login/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="index.php?controlador=User&accion=verificarRegistro" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Nombre: " required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email: " required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña: " required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="repeat_password" placeholder="Repite la contraseña: " required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Enviar" name="submit">
            </div>
        </form>
    </div>
</body>
</html>
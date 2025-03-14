
<link href="./assets/login/login.css" rel="stylesheet">

</head>
<body>
    <div class="container">
        <form action="index.php?controlador=User&accion=verificarLogin" method="post">
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email: " required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña: " required>
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Entrar" name="submit">
            </div>
        </form>
    </div>
</body>
</html>

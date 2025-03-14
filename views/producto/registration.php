<?php require_once "views/shared/header.php"; ?>
<link href="../../assets/login/login.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php
        if(isset($_POST["submit"])){
            $fullName = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
        }
        ?>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Nombre: ">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email: ">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Contraseña: ">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="repeat_password" placeholder="Repite la contraseña: ">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Enviar" name="submit">
            </div>
        </form>
    </div>
</body>
</html>
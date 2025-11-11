<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="../estilos/login_style.css">
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <!-- Formulario para recuperar contraseña -->
    <form action="verificar_usuario.php" method="post">
        <div class="form-header">
            <img src="../imagenes/OK.png" alt="Logo" class="header-image">
            <h2>Recuperar su contraseña</h2>
        </div>

        <p>Ingrese su Email y la clave de recuperación para continuar con el cambio de contraseña</p>
        
        <!-- Campo para el correo electrónico -->
        <div class="input-wrapper">
            <input type="email" name="email" placeholder="Correo Electrónico" required="">
        </div>

        <!-- Campo para la clave de recuperación -->
        <!-- <div class="input-wrapper"> -->
            <!-- Cambié el nombre de 'recuperacion_clave' a 'clave' para que coincida con el código PHP -->
            <!-- <input type="text" name="clave" placeholder="Clave de Recuperación" required=""> -->
        <!-- </div> -->

        <!-- Botón para enviar el formulario -->
        <input class="btn" type="submit" name="verify" value="Continuar">

        <p><a href="../bases/index.php" class="create-account">Volver al inicio</a></p>
    
    </form>

</body>
</html>

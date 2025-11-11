<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Alumnos - OK NOTEBOOKS</title>
    <link rel="stylesheet" href="../estilos/register_style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="icon" href="../imagenes/logo.ico">
</head>
<body>

    <!-- Formulario para el registro de alumnos -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="form-header">
            <img src="../imagenes/OK.png" alt="Logo" class="header-image">
            <h2>Registro de alumnos</h2>
        </div>

        <!-- Campo para ingresar el nombre completo -->
        <div class="input-wrapper">
            <input type="text" name="name" placeholder="Nombre Completo" required="">
        </div>

        <!-- Campo para ingresar el correo electrónico -->
        <div class="input-wrapper">
            <input type="email" name="email" placeholder="Correo Electronico" required="">
        </div>

        <!-- Campo para ingresar la contraseña -->
        <div class="input-wrapper">
            <input type="password" name="password" id="password" placeholder="Contraseña" required="" onkeyup="checkPassword()">
            <i class='bx bx-show-alt' id="toggle-password"></i>
        </div>

        <!-- Campo para ingresar la división -->
        <div class="input-wrapper">
            <input type="text" name="division" id="division" placeholder="Division" required="" oninput="validateDivision()">
        </div>

        <!-- Selector de especialidad -->
        <div class="input-wrapper" id="especialidad-wrapper" style="display:none;">
            <select name="especial" id="especial">
                <option value="" disabled selected>Selecciona tu Especialidad</option>
                <option value="Computacion">Computacion</option>
                <option value="Construcciones">Construcciones</option>
                <option value="Electricidad">Electricidad</option>
                <option value="Electronica">Electronica</option>
                <option value="Mecanica">Mecanica</option>
                <option value="Quimica">Quimica</option>
            </select>
        </div>

        <!-- Campo para ingresar la clave numérica -->
        <!-- <div class="input-wrapper">
            <input type="text" name="clave" id="clave" placeholder="Clave Numérica (5-8 dígitos)" pattern="^\d{5,8}$" required="">
        </div> -->

        <div id="password-requirements" class="password-requirements">
            <ul>
                <li>La contraseña debe cumplir los siguientes requisitos: </li>
                <li id="length" class="invalid">Al menos 8 caracteres</li>
                <li id="lowercase" class="invalid">Debe contener al menos una letra minúscula</li>
                <li id="number" class="invalid">Debe incluir al menos un número</li>
            </ul>
        </div>

        <input class="btn" type="submit" name="register" value="Enviar">

        <p>Ya tienes un usuario? -> <a href="../bases/login.php" class="create-account">Ingrese aqui</a></p>
        <p>Si eres un profesor, ingresa al siguiente enlace -> <a href="../bases/register_profe.php" class="create-account">Ingrese aqui</a></p>
        <!-- <p><a href="../bases/index.php" class="create-account"> <-- Volver al inicio</a></p> -->
    </form>


    <?php
        // Incluye el archivo para registrar al alumno si se envía el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            include("../bases/RegistrarAlumno.php");
        }
    ?>

        <script>
        function checkPassword() {
            var password = document.getElementById('password').value;

            // Requisitos de la contraseña
            var lengthRequirement = document.getElementById('length');
            var lowercaseRequirement = document.getElementById('lowercase');
            var numberRequirement = document.getElementById('number');

            // Validar los requisitos
            var isLengthValid = password.length >= 8;
            var isLowercaseValid = /[a-z]/.test(password);
            var isNumberValid = /\d/.test(password);

            // Cambiar el estado de los requisitos según la contraseña
            lengthRequirement.classList.toggle('valid', isLengthValid);
            lengthRequirement.classList.toggle('invalid', !isLengthValid);

            lowercaseRequirement.classList.toggle('valid', isLowercaseValid);
            lowercaseRequirement.classList.toggle('invalid', !isLowercaseValid);

            numberRequirement.classList.toggle('valid', isNumberValid);
            numberRequirement.classList.toggle('invalid', !isNumberValid);
        }
    </script>
    <!-- <script src="../js/script.js"></script> -->
    <script src="../js/grado.js"></script>
</body>
</html>

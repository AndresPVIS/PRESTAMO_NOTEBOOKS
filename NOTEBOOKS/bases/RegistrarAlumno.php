<?php 
// Incluye el archivo de conexión a la base de datos
include("../bases/conexion.php");

function determinarTipoUsuario($nombre) {
    return 'Alumno';
}

if (isset($_POST['register'])) {
    $division = trim($_POST['division']);
    $division_valida = false;
    $especial_existe = isset($_POST['especial']) && strlen(trim($_POST['especial'])) >= 1;

    // Validación de la división
    if (!preg_match('/^[\d°]+$/', $division)) {
        echo "<h3 class='error'>La división debe contener solo números y el símbolo '°'.</h3>";
        exit();
    }

    $cleanDivision = str_replace('°', '', $division);
    $primer_digito = (int) substr($cleanDivision, 0, 1);
    $especialidad = '';

    if ($primer_digito >= 1 && $primer_digito <= 3) {
        $especialidad = "Ciclo Básico";
    } elseif ($primer_digito >= 4 && $primer_digito <= 6) {
        $division_valida = true;
        if ($especial_existe) {
            $especialidad = trim($_POST['especial']);
        } else {
            echo "<h3 class='error'>Por favor, selecciona una especialidad.</h3>";
            exit();
        }
    } else {
        echo "<h3 class='error'>El Año debe estar en el rango de 1 a 6.</h3>";
        exit();
    }

    // Verificar que los campos necesarios no estén vacíos
    // if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1 &&
    //     strlen($_POST['clave']) >= 1 && (!$division_valida || $especial_existe)) {
    if (strlen($_POST['name']) >= 1 && strlen($_POST['email']) >= 1 && strlen($_POST['password']) >= 1 &&
        (!$division_valida || $especial_existe)) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        if (strlen($password) >= 8 && preg_match('/[a-z]/', $password) && preg_match('/\d/', $password)) {
        // $clave = trim($_POST['clave']); // Recupera la clave proporcionada por el usuario
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $fecha = date("Y-m-d");
        $tipo_usuario = determinarTipoUsuario($name);
        $activo = 0; // Valor por defecto para la cuenta inactiva
        }
        // else{
        //     echo "<h3 class='error'>la contraseña no cumple con las validaciones.</h3>";
        // }


        // Verificar si el correo ya está registrado
        $checkEmailQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ?");
        if (!$checkEmailQuery) {
            die("Error en la preparación de la consulta: " . $conex->error);
        }

        $checkEmailQuery->bind_param("s", $email);
        if (!$checkEmailQuery->execute()) {
            die("Error al ejecutar la consulta de verificación de correo: " . $checkEmailQuery->error);
        }

        $checkEmailQuery->store_result();
        if ($checkEmailQuery->num_rows > 0) {
            echo "<h3 class='error'>El correo ya está registrado. Por favor, use un correo diferente.</h3>";
        } else {
            if(strlen($password) >= 8 && preg_match('/[a-z]/', $password) && preg_match('/\d/', $password)){
            // Insertar los datos del usuario en la base de datos, incluyendo la clave proporcionada por el usuario
            // $consulta = $conex->prepare("INSERT INTO usuario(nombre, email, contraseña, division, especialidad, tipo_usuario, fecha, activo, clave) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $consulta = $conex->prepare("INSERT INTO usuario(nombre, email, contraseña, division, especialidad, tipo_usuario, fecha, activo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($consulta) {
                // $consulta->bind_param("ssssssssd", $name, $email, $hashed_password, $division, $especialidad, $tipo_usuario, $fecha, $activo, $clave);
                $consulta->bind_param("ssssssss", $name, $email, $hashed_password, $division, $especialidad, $tipo_usuario, $fecha, $activo);
                if ($consulta->execute()) {
                    // Mostrar mensaje de notificación en lugar de mensaje en verde
                    echo "<div id='success-notification' class='notification success-notification'>
                            <p>Tu usuario se ha creado exitosamente, espera la validación por parte de un administrador.</p>
                          </div>";
                } else {
                    echo "<h3 class='error'>Ocurrió un error al registrarse: " . $consulta->error . "</h3>";
                }
                $consulta->close();
            } else {
                echo "<h3 class='error'>Error en la preparación de la consulta de inserción: " . $conex->error . "</h3>";
            }
          }
        }
        $checkEmailQuery->close();
    } else {
        echo "<h3 class='error'>Llena todos los campos correctamente.</h3>";
    }
}
?>

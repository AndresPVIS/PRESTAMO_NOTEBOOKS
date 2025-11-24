<?php
// Incluir la conexión a la base de datos
include("../bases/conexion.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';

// require '../PHPMailer/Exception.php';
// require '../PHPMailer/PHPMailer.php';
// require '../PHPMailer/SMTP.php';


// Verificar si el formulario ha sido enviado
if (isset($_POST['verify'])) {
    // Obtener el email y la clave de recuperación del formulario
    $email = trim($_POST['email']);
    // $recuperacion_clave = trim($_POST['clave']);  // Ahora coinciden con el campo del formulario

    // Preparar la consulta para verificar si el email y la clave de recuperación existen en la base de datos
    // $checkQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ? AND clave = ?");
    $checkQuery = $conex->prepare("SELECT * FROM usuario WHERE email = ?");
    // $checkQuery->bind_param("ss", $email, $recuperacion_clave); 
    $checkQuery->bind_param("s", $email);


    if ($checkQuery->execute()) {
        // Verificar si se encontró el usuario con el email y la clave de recuperación
        $result = $checkQuery->get_result();
        if ($result->num_rows > 0) {
            // Si el email y la clave de recuperación coinciden, redirigir al formulario de cambio de contraseña
            $row = $result->fetch_assoc();
            $email = $row['email']; // Recuperamos el email
//aca va la nueva implementacion
            $mail = new PHPMailer(true);
            try{
                
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'example@test.com';  //aca va el mail el cual enviara el link de cambio de contraseña
                $mail->Password   = 'rpsm jlor kntp vyrs';  // contraseña encriptada de la cuenta del mail (cambiar segun el mail utilizado)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('example@test.com', 'reseteo de contraseña');  //colocar el mismo mail 
                $mail->addAddress($email, 'test');
                $mail->isHTML(true);
                $mail->Subject = 'Recuperación de contraseña';
                $mail->Body    = ' accede al siguiente link para cambiar tu contraseña: http://localhost/prestamo_notebooks/NOTEBOOKS/bases/cambiar_password.php?email='. urlencode($email) ;
                $mail->send();
                // header("Location: ../index.php?message=ok");
            }catch(Exception $e){
                echo "<h3 class='error'>hay un error</h3>";
            }
            // Redirigir al formulario para cambiar la contraseña, pasando el email como parámetro
            // header("Location: cambiar_password.php?email=" . urlencode($email) ); 
            // echo "<div id='success-notification' class='notification success-notification'>
            //                 <p>Tu usuario se ha creado exitosamente, espera la validación por parte de un administrador.</p>
            //               </div>";
            //copiar y pegar html
             sleep(5); //tiempo de espera 5seg
             header("location: login.php"); //manda al inicio de sesion
            exit();
        } else {
            // Si no se encuentra el email o la clave, mostrar un mensaje de error
            echo "<h3 class='error'>El correo electrónico o la clave de recuperación no son válidos.</h3>";
        }
    } else {
        // Si hay un error en la consulta
        echo "<h3 class='error'>Error en la consulta de verificación.</h3>";
    }
    
    // Cerrar la conexión
    $checkQuery->close();
    mysqli_close($conex);
}
?>


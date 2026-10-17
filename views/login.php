<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controller/AuthController.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo'] ?? '');
    $clave = trim($_POST['clave'] ?? '');

    if ($correo === '' || $clave === '') {
        $mensaje = 'Complete todos los campos';
    } else {
        $auth = new AuthController();

        if ($auth->login($correo, $clave)) {
            header('Location: home.php');
            exit;
        }

        $mensaje = 'Correo o clave incorrectos';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="description" content="Calculo del area y perimetro del triangulo">
    <meta name="keywords" content="triangulo, matematicas, sistema, base de datos">
    <meta name="author" content="Alexis CT">

    <link rel="icon" href="../imagenes/icono.png">
    <link rel="stylesheet" href="../assetes/css/style.css">

    <title>Triángulo - Iniciar Sesión</title>
</head>
<body>
    <header>
    </header>
    <main>
        <div class="caja">
            <form action="" method="post" id="frmLogin">
                <img src="../imagenes/logo.jpg" alt="logo de matematicas">
                <h2 style="margin-bottom: 18px; color: var(--texto); font-size: 22px;">Acceso al Sistema</h2>
                <input type="email" name="correo" id="correo" placeholder="Correo (ej. admin@triangulo.com)" required>
                <input type="password" name="clave" id="clave" placeholder="Clave" required>
                <button type="submit" id="btnIngresar">Ingresar</button>
            </form>
            <?php if (!empty($mensaje)) : ?>
                <script>
                    alert("<?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?>");
                </script>
            <?php endif; ?>
        </div>
    </main>
    <footer>
    </footer>
    <script src="../assetes/js/app.js"></script>
</body>
</html>
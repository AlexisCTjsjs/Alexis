<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controller/AuthController.php';
require_once __DIR__ . '/../controller/TrianguloController.php';

AuthController::verificarSesion();

$trianguloController = new TrianguloController();
$mensaje = $_GET['mensaje'] ?? '';
$mensajeFormulario = $trianguloController->procesarFormulario();

if ($mensajeFormulario !== '') {
    $mensaje = $mensajeFormulario;
}

$buscar = trim($_GET['buscar'] ?? '');
$registroEditar = null;

if (isset($_GET['editar'])) {
    $registroEditar = $trianguloController->obtenerParaEditar((int) $_GET['editar']);
}

$registros = $trianguloController->listar($buscar);

$idActual = $registroEditar['id_triangulo'] ?? '';
$baseActual = $registroEditar['base'] ?? '';
$alturaActual = $registroEditar['altura'] ?? '';
$lado1Actual = $registroEditar['lado1'] ?? '';
$lado2Actual = $registroEditar['lado2'] ?? '';
$lado3Actual = $registroEditar['lado3'] ?? '';
$detalleActual = $registroEditar['detalle'] ?? '';
$areaActual = $registroEditar['area'] ?? '';
$perimetroActual = $registroEditar['perimetro'] ?? '';
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
    <link rel="stylesheet" href="../assetes/css/style_home.css">

    <title>Triángulo - Sistema Principal</title>
</head>
<body>
    <header class="headeerHome">
        <div class="lineaSup">
            <div class="logo-links">
                <div class="logo">
                    <img src="../imagenes/logo.jpg" alt="Logo de matematicas">
                    <h1>Triángulo Matemático</h1>
                </div>               
                <a href="#">Quienes somos</a>
            </div>
            <div class="buscarHeader">
                <form class="form1" action="home.php" method="get">
                    <img src="../imagenes/logo.jpg" alt="icono buscar">
                    <button type="submit">Buscar</button>
                    <input type="text" name="buscar" placeholder="Buscar en historial..."
                    value="<?php echo htmlspecialchars($buscar); ?>">
                </form>
            </div>
        </div>
        <div class="lineaInf">
            <nav class="menu">
                <li>
                    <a href="home.php">Inicio</a>
                </li>
                <li>
                    <a href="#">Nuestra historia</a>
                </li>
                <li>
                    <a href="logout.php" onclick="return confirm('¿Desea salir del sistema?');">Cerrar sesión</a>
                </li>
            </nav>
        </div>
    </header>

    <main>
        <div class="datos">
            <div class="titulo">
                <h1>Cálculo del área y perímetro del triángulo</h1>
                <p>Usuario activo: <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong></p>
            </div>

            <div class="formula-info">
                <span class="formula-badge">📐 Área = (Base × Altura) / 2</span>
                <span class="formula-badge">📏 Perímetro = Lado 1 + Lado 2 + Lado 3</span>
            </div>

            <?php if ($mensaje !== '') : ?>
                <p class="mensaje">
                    <?php echo htmlspecialchars(ucfirst($mensaje)); ?>
                </p>
            <?php endif; ?>

            <form action="" method="post" class="form2" id="frmFormulario">
                <input type="hidden" name="id_triangulo" value="<?php echo htmlspecialchars($idActual); ?>">

                <div class="form-grid">
                    <div class="inputs">
                        <label for="txtBase">Base (b)</label>
                        <input class="inputHome" type="number" step="any" min="0.01" name="txtBase" id="txtBase" placeholder="Base del triángulo" required
                         value="<?php echo htmlspecialchars($baseActual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtAltura">Altura (h)</label>
                        <input class="inputHome" type="number" step="any" min="0.01" name="txtAltura" id="txtAltura" placeholder="Altura relativa a la base" required
                         value="<?php echo htmlspecialchars($alturaActual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtLado1">Lado 1 (Base)</label>
                        <input class="inputHome" type="number" step="any" min="0.01" name="txtLado1" id="txtLado1" placeholder="Longitud lado 1" required
                         value="<?php echo htmlspecialchars($lado1Actual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtLado2">Lado 2</label>
                        <input class="inputHome" type="number" step="any" min="0.01" name="txtLado2" id="txtLado2" placeholder="Longitud lado 2" required
                         value="<?php echo htmlspecialchars($lado2Actual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtLado3">Lado 3</label>
                        <input class="inputHome" type="number" step="any" min="0.01" name="txtLado3" id="txtLado3" placeholder="Longitud lado 3" required
                         value="<?php echo htmlspecialchars($lado3Actual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtDetalle">Comentario</label>
                        <input class="inputHome" type="text" placeholder="Opcional: Detalle o descripción"
                        name="txtDetalle" id="txtDetalle" value="<?php echo htmlspecialchars($detalleActual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtA">Área</label>
                        <input class="inputHome" type="text" name="txtA" id="txtA" readonly placeholder="Área calculada"
                         value="<?php echo htmlspecialchars($areaActual); ?>">
                    </div>

                    <div class="inputs">
                        <label for="txtP">Perímetro</label>
                        <input class="inputHome" type="text" name="txtP" id="txtP" readonly placeholder="Perímetro calculado"
                         value="<?php echo htmlspecialchars($perimetroActual); ?>">
                    </div>
                </div>

                <div class="botones">
                    <button type="button" id="btnCalcular" onclick="calcularTriangulo();">Calcular</button>
                    <a class="btn-link cancelar" href="home.php">Cancelar</a>
                    <button type="submit" name="accion" value="guardar">
                        <?php echo $idActual !== '' ? 'Actualizar' : 'Guardar'; ?>
                    </button>
                </div>
            </form>
        </div>

        <div class="buscar">
            <form action="home.php" method="get" id="frmBuscar">
                <img src="../imagenes/logo.jpg" alt="icono buscar">
                <button type="submit">Buscar</button>
                <input type="text" name="buscar" id="txtBuscar" placeholder="Buscar por base, altura, lados, área, perímetro o comentario..."
                 value="<?php echo htmlspecialchars($buscar); ?>">
                <a class="btn-link limpiar" href="home.php">Limpiar</a>
            </form>
        </div>

        <div class="tabla">
            <h1>Historial de Cálculos del Triángulo</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Base</th>
                        <th>Altura</th>
                        <th>Lado 1</th>
                        <th>Lado 2</th>
                        <th>Lado 3</th>
                        <th>Detalle</th>
                        <th>Área</th>
                        <th>Perímetro</th>
                        <th>Fecha y hora</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($registros) > 0) : ?>
                        <?php foreach ($registros as $fila) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($fila['id_triangulo']); ?></td>
                                <td><?php echo htmlspecialchars($fila['base']); ?></td>
                                <td><?php echo htmlspecialchars($fila['altura']); ?></td>
                                <td><?php echo htmlspecialchars($fila['lado1']); ?></td>
                                <td><?php echo htmlspecialchars($fila['lado2']); ?></td>
                                <td><?php echo htmlspecialchars($fila['lado3']); ?></td>
                                <td><?php echo htmlspecialchars($fila['detalle'] ?? '-'); ?></td>
                                <td><strong><?php echo htmlspecialchars($fila['area']); ?></strong></td>
                                <td><strong><?php echo htmlspecialchars($fila['perimetro']); ?></strong></td>
                                <td><?php echo htmlspecialchars($fila['fecha_registro']); ?></td>
                                <td class="acciones">
                                    <a class="btn-tabla editar" href="home.php?editar=<?php echo (int) $fila['id_triangulo']; ?>">Editar</a>

                                    <form action="" method="post" onsubmit="return confirm('¿Desea eliminar este registro?');" style="display:inline;">
                                        <input type="hidden" name="id_triangulo" value="<?php echo (int) $fila['id_triangulo']; ?>">
                                        <button class="btn-tabla eliminar" type="submit" name="accion" value="eliminar">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="11">No hay registros de triángulos para mostrar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script src="../assetes/js/app.js?v=3"></script>
</body>
</html>
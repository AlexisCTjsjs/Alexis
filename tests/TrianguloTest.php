<?php
require_once __DIR__ . '/../model/Triangulo.php';

function comprobar(bool $condicion, string $mensaje): void
{
    if (!$condicion) {
        fwrite(STDERR, $mensaje . PHP_EOL);
        exit(1);
    }
}

comprobar(abs(Triangulo::calcularAltura(10, 25) - 5) < 0.000001, 'Debe calcular la altura usando base y área.');
comprobar(Triangulo::esTrianguloValido(3, 4, 5), 'Debe aceptar un triángulo válido.');
comprobar(!Triangulo::esTrianguloValido(1, 2, 3), 'Debe rechazar lados que no forman un triángulo.');
comprobar(!Triangulo::esTrianguloValido(1, 0, 1), 'Debe rechazar lados que no sean positivos.');
comprobar(!Triangulo::esTrianguloValido(NAN, 2, 2), 'Debe rechazar medidas no finitas.');
comprobar(!Triangulo::esTrianguloValido(1.0e308, 1.0e308, 1.0e308), 'Debe rechazar perímetros fuera de rango.');

$baseInvalidaRechazada = false;
try {
    Triangulo::calcularAltura(0, 25);
} catch (InvalidArgumentException) {
    $baseInvalidaRechazada = true;
}
comprobar($baseInvalidaRechazada, 'Debe rechazar una base igual a cero.');

echo "Pruebas de cálculo de altura correctas." . PHP_EOL;

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

try {
    Triangulo::calcularAltura(0, 25);
    comprobar(false, 'Debe rechazar una base igual a cero.');
} catch (InvalidArgumentException $error) {
}

echo "Pruebas de cálculo de altura correctas." . PHP_EOL;

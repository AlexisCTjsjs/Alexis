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

try {
    Triangulo::calcularAltura(0, 25);
    comprobar(false, 'Debe rechazar una base igual a cero.');
} catch (InvalidArgumentException $error) {
}

echo "Pruebas de cálculo de altura correctas." . PHP_EOL;

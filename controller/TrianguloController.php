<?php
require_once __DIR__ . '/../model/Triangulo.php';

class TrianguloController
{
    private Triangulo $modelo;

    public function __construct()
    {
        $this->modelo = new Triangulo();
    }

    public function procesarFormulario(): string
    {
        if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
            return '';
        }

        $accion = $_POST['accion'] ?? '';

        if ($accion === 'calcular_altura') {
            return $this->calcularAltura();
        }

        if ($accion === 'guardar') {
            return $this->guardarOActualizar();
        }

        if ($accion === 'eliminar') {
            return $this->eliminar();
        }

        return '';
    }

    private function calcularAltura(): string
    {
        $base = trim($_POST['baseCalculoAltura'] ?? '');
        $area = trim($_POST['areaConocida'] ?? '');

        if (!is_numeric($base) || !is_numeric($area)) {
            return 'Ingrese una base y un área válidas para encontrar la altura.';
        }

        $base = (float) $base;
        $area = (float) $area;

        if (!is_finite($base) || !is_finite($area) || $base <= 0 || $area <= 0) {
            return 'La base y el área deben ser mayores que cero.';
        }

        $altura = Triangulo::calcularAltura($base, $area);
        return 'La altura del triángulo es ' . number_format($altura, 2, '.', '') . '.';
    }

    private function guardarOActualizar(): string
    {
        $id = (int) ($_POST['id_triangulo'] ?? 0);
        $detalle = trim($_POST['txtDetalle'] ?? '');
        $base = trim($_POST['txtBase'] ?? '');
        $altura = trim($_POST['txtAltura'] ?? '');
        $lado1 = trim($_POST['txtLado1'] ?? '');
        $lado2 = trim($_POST['txtLado2'] ?? '');
        $lado3 = trim($_POST['txtLado3'] ?? '');

        // Si lado1 está vacío pero base tiene valor, por defecto lado1 es la base
        if ($lado1 === '' && $base !== '') {
            $lado1 = $base;
        }

        if ($base === '' || !is_numeric($base) || (float) $base <= 0) {
            return 'Ingrese una base válida mayor a cero';
        }

        if ($altura === '' || !is_numeric($altura) || (float) $altura <= 0) {
            return 'Ingrese una altura válida mayor a cero';
        }

        if ($lado1 === '' || !is_numeric($lado1) || (float) $lado1 <= 0 ||
            $lado2 === '' || !is_numeric($lado2) || (float) $lado2 <= 0 ||
            $lado3 === '' || !is_numeric($lado3) || (float) $lado3 <= 0) {
            return 'Ingrese valores numéricos válidos mayores a cero para los tres lados';
        }

        $b = (float) $base;
        $h = (float) $altura;
        $l1 = (float) $lado1;
        $l2 = (float) $lado2;
        $l3 = (float) $lado3;

        if (!is_finite($b) || !is_finite($h) || !is_finite($l1) ||
            !is_finite($l2) || !is_finite($l3)) {
            return 'Las medidas deben ser números finitos.';
        }

        if (!Triangulo::esTrianguloValido($l1, $l2, $l3)) {
            return 'Las longitudes de los lados no forman un triángulo válido.';
        }

        if (!is_finite(($b * $h) / 2) || !is_finite($l1 + $l2 + $l3)) {
            return 'Las medidas son demasiado grandes para calcular el área y el perímetro.';
        }

        if ($id > 0) {
            $this->modelo->actualizar($id, $detalle, $b, $h, $l1, $l2, $l3);
            header('Location: home.php?mensaje=actualizado');
            exit;
        }

        $this->modelo->guardar($detalle, $b, $h, $l1, $l2, $l3);
        header('Location: home.php?mensaje=guardado');
        exit;
    }

    private function eliminar(): string
    {
        $id = (int) ($_POST['id_triangulo'] ?? 0);

        if ($id <= 0) {
            return 'No se pudo eliminar el registro';
        }

        $this->modelo->eliminar($id);
        header('Location: home.php?mensaje=eliminado');
        exit;
    }

    public function listar(string $buscar = ''): array
    {
        return $this->modelo->listar($buscar);
    }

    public function obtenerParaEditar(int $id): ?array
    {
        if ($id <= 0) {
            return null;
        }

        return $this->modelo->obtenerPorId($id);
    }
}

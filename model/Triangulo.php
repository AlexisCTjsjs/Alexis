<?php
require_once __DIR__ . '/../config/Database.php';

class Triangulo
{
    private PDO $pdo;

    public static function calcularAltura(float $base, float $area): float
    {
        if (!is_finite($base) || !is_finite($area) || $base <= 0 || $area <= 0) {
            throw new InvalidArgumentException('La base y el área deben ser mayores que cero.');
        }

        return (2 * $area) / $base;
    }

    public static function esTrianguloValido(float $lado1, float $lado2, float $lado3): bool
    {
        if (!is_finite($lado1) || !is_finite($lado2) || !is_finite($lado3) ||
            $lado1 <= 0 || $lado2 <= 0 || $lado3 <= 0 ||
            !is_finite($lado1 + $lado2 + $lado3)) {
            return false;
        }

        return $lado1 + $lado2 > $lado3 &&
            $lado1 + $lado3 > $lado2 &&
            $lado2 + $lado3 > $lado1;
    }

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->conectar();
    }

    public function listar(string $buscar = ''): array
    {
        if ($buscar !== '') {
            $sql = "SELECT * FROM triangulo
                    WHERE detalle LIKE :buscarDetalle
                       OR CAST(base AS CHAR) LIKE :buscarBase
                       OR CAST(altura AS CHAR) LIKE :buscarAltura
                       OR CAST(lado1 AS CHAR) LIKE :buscarLado1
                       OR CAST(lado2 AS CHAR) LIKE :buscarLado2
                       OR CAST(lado3 AS CHAR) LIKE :buscarLado3
                       OR CAST(area AS CHAR) LIKE :buscarArea
                       OR CAST(perimetro AS CHAR) LIKE :buscarPerimetro
                    ORDER BY id_triangulo DESC";
            $stmt = $this->pdo->prepare($sql);

            $valorBuscar = '%' . $buscar . '%';

            $stmt->execute([
                'buscarDetalle' => $valorBuscar,
                'buscarBase' => $valorBuscar,
                'buscarAltura' => $valorBuscar,
                'buscarLado1' => $valorBuscar,
                'buscarLado2' => $valorBuscar,
                'buscarLado3' => $valorBuscar,
                'buscarArea' => $valorBuscar,
                'buscarPerimetro' => $valorBuscar,
            ]);

            return $stmt->fetchAll();
        }

        $sql = "SELECT * FROM triangulo ORDER BY id_triangulo DESC";
        return $this->pdo->query($sql)->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT * FROM triangulo WHERE id_triangulo = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $registro = $stmt->fetch();

        return $registro ?: null;
    }

    public function guardar(string $detalle, float $base, float $altura, float $lado1, float $lado2, float $lado3): bool
    {
        $area = round(($base * $altura) / 2, 2);
        $perimetro = round($lado1 + $lado2 + $lado3, 2);

        $sql = "INSERT INTO triangulo(detalle, base, altura, lado1, lado2, lado3, area, perimetro)
                VALUES(:detalle, :base, :altura, :lado1, :lado2, :lado3, :area, :perimetro)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'detalle' => $detalle,
            'base' => $base,
            'altura' => $altura,
            'lado1' => $lado1,
            'lado2' => $lado2,
            'lado3' => $lado3,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function actualizar(int $id, string $detalle, float $base, float $altura, float $lado1, float $lado2, float $lado3): bool
    {
        $area = round(($base * $altura) / 2, 2);
        $perimetro = round($lado1 + $lado2 + $lado3, 2);

        $sql = "UPDATE triangulo
                SET detalle = :detalle,
                    base = :base,
                    altura = :altura,
                    lado1 = :lado1,
                    lado2 = :lado2,
                    lado3 = :lado3,
                    area = :area,
                    perimetro = :perimetro
                WHERE id_triangulo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'id' => $id,
            'detalle' => $detalle,
            'base' => $base,
            'altura' => $altura,
            'lado1' => $lado1,
            'lado2' => $lado2,
            'lado3' => $lado3,
            'area' => $area,
            'perimetro' => $perimetro,
        ]);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM triangulo WHERE id_triangulo = :id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }
}

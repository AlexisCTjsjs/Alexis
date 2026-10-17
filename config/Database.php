<?php
class Database{
    private string $host = 'localhost';
    private string $db = 'triangulo_db';
    private string $user = 'root';
    private string $pass = '';
    private string $charset = 'utf8mb4';

    public function conectar(): PDO{
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            return new PDO($dsn, $this->user, $this->pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false 
            ]);
        } catch (PDOException $e) {
            // Si la base de datos no existe todavía, intentar inicializarla automáticamente
            try {
                $dsnHost = "mysql:host={$this->host};charset={$this->charset}";
                $pdoHost = new PDO($dsnHost, $this->user, $this->pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
                $pdoHost->exec("CREATE DATABASE IF NOT EXISTS `{$this->db}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                
                $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
                $pdo = new PDO($dsn, $this->user, $this->pass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false 
                ]);
                
                $this->inicializarTablas($pdo);
                return $pdo;
            } catch (PDOException $ex) {
                die('Error de conexion a la base de datos: ' . $e->getMessage());
            }
        }
    }

    private function inicializarTablas(PDO $pdo): void{
        $sql = "
            CREATE TABLE IF NOT EXISTS `usuario` (
              `id_usuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `nombre` VARCHAR(150) NOT NULL DEFAULT '',
              `correo` VARCHAR(255) NOT NULL,
              `clave` VARCHAR(255) NOT NULL,
              PRIMARY KEY (`id_usuario`),
              UNIQUE KEY `uq_usuario_correo` (`correo`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            CREATE TABLE IF NOT EXISTS `triangulo` (
              `id_triangulo` INT UNSIGNED NOT NULL AUTO_INCREMENT,
              `detalle` TEXT NULL,
              `base` DOUBLE NOT NULL,
              `altura` DOUBLE NOT NULL,
              `lado1` DOUBLE NOT NULL,
              `lado2` DOUBLE NOT NULL,
              `lado3` DOUBLE NOT NULL,
              `area` DOUBLE NOT NULL,
              `perimetro` DOUBLE NOT NULL,
              `fecha_registro` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id_triangulo`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            INSERT INTO `usuario` (`nombre`, `correo`, `clave`)
            SELECT 'Administrador', 'admin@triangulo.com', '123'
            WHERE NOT EXISTS (SELECT 1 FROM `usuario` WHERE `correo` = 'admin@triangulo.com');
        ";
        $pdo->exec($sql);
    }
}
# Triángulo Matemático

Aplicación PHP para calcular el área y el perímetro de triángulos, guardar resultados y consultar el historial. El proyecto separa las vistas, controladores y modelos.

## Requisitos

- PHP 8.0 o posterior con PDO MySQL
- MySQL o MariaDB
- XAMPP (opcional, para ejecutar localmente)

## Instalación con XAMPP

1. Copia el proyecto en `C:\xampp\htdocs\triangulo`.
2. Inicia Apache y MySQL desde el panel de XAMPP.
3. Importa `database/base_datos.txt` desde phpMyAdmin. La base de datos se llama `triangulo_db`.
4. Si tus credenciales de MySQL no son `root` sin contraseña, actualiza los valores de conexión en `config/Database.php`.
5. Abre `http://localhost/triangulo/` en el navegador.

La aplicación crea las tablas al conectarse por primera vez. El usuario de demostración es `admin@triangulo.com` con clave `123`; cámbialo antes de usarla fuera de un entorno local.

## Estructura MVC

- `model/`: acceso a datos y cálculos.
- `controller/`: validación y flujo de las operaciones.
- `views/`: inicio de sesión e interfaz del sistema.
- `config/`: conexión con MySQL.
- `database/`: script SQL para crear la base y las tablas.
# Triángulo Matemático

Aplicación web en PHP para calcular el área y el perímetro de triángulos, encontrar una altura desconocida a partir de la base y el área, y guardar las mediciones en un historial.

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

## Funciones

- Calcula el área con la base y la altura.
- Calcula el perímetro con los tres lados y rechaza medidas que no formen un triángulo válido.
- Encuentra una altura usando el área conocida y la base (`h = 2A / b`).
- Guarda, edita, elimina y busca cálculos en el historial.
- Incluye inicio de sesión y una interfaz adaptable a pantallas pequeñas.

## Pruebas

Ejecuta las pruebas de fórmulas y validación geométrica desde la carpeta del proyecto:

```powershell
C:\xampp\php\php.exe tests\TrianguloTest.php
```

También puedes comprobar la sintaxis de todos los archivos PHP:

```powershell
Get-ChildItem -Recurse -Filter *.php | ForEach-Object { C:\xampp\php\php.exe -l $_.FullName }
```

## Estructura MVC

- `model/`: acceso a datos y cálculos.
- `controller/`: validación y flujo de las operaciones.
- `views/`: inicio de sesión e interfaz del sistema.
- `config/`: conexión con MySQL.
- `database/`: script SQL para crear la base y las tablas.

## Versiones

Cada versión corresponde a un commit y una etiqueta Git:

| Versión | Entrega |
| --- | --- |
| `v1` | Aplicación inicial MVC para cálculos e historial de triángulos |
| `v1.1` | Cálculo de altura desde base y área |
| `v1.2` | Validación de las proporciones de los lados |
| `v1.3` | Mejoras de accesibilidad |
| `v1.4` | Cálculo independiente de área y perímetro |
| `v1.5` | Diseño geométrico propio y adaptable |
| `v1.6` | Documentación y pruebas ampliadas |
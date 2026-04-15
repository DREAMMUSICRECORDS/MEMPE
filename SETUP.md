# MI MEMPE - Calendario Menstrual
**Versión Corregida y Funcional en XAMPP**

## Correcciones Realizadas ✓

### 1. **Autenticación de Usuarios**
- ✓ Implementado sistema de login en `index.php`
- ✓ Implementado sistema de registro en `index.php`
- ✓ Creado archivo `logout.php` para cerrar sesión
- ✓ Sistema de sesiones funcional con validación

### 2. **Protección de Páginas**
- ✓ `calendarioAdmin.php` : Requiere autenticación
- ✓ `actualizar_perfil.php` : Requiere autenticación
- ✓ `periodo.php` : Requiere autenticación

### 3. **Base de Datos**
- ✓ Estructura de base de datos XAMPP lista
- ✓ Tablas: usuarios, fechas_periodo, sintomas, citas
- ✓ Archivo `init_database.php` para inicializar BD

### 4. **Archivos Corregidos**
- ✓ `index.php` : Procesa login y registro correctamente
- ✓ `calendarioAdmin.php` : Verifica sesión
- ✓ `actualizar_perfil.php` : Valida sesión y procesa datos
- ✓ `logout.php` : Nuevo archivo para cerrar sesión
- ✓ `registro.php` : Redirige a index.php
- ✓ `conexion.php` : Configuración XAMPP correcta

## Pasos para Usar ⚙️

### 1. Inicializar la Base de Datos
1. Abre XAMPP Control Panel
2. Inicia Apache y MySQL
3. Accede a: `http://localhost/mempe/init_database.php`
4. Deberías ver mensajes de confirmación de tablas creadas

### 2. Acceder a la Aplicación
1. Ve a: `http://localhost/mempe/`
2. Verás la pantalla de login/registro

### 3. Registrarse
- Haz clic en la pestaña "Registrarse"
- Rellena nombre, email y contraseña
- La contraseña debe tener al menos 6 caracteres
- Haz clic en "Crear Cuenta"

### 4. Iniciar Sesión
- Pestaña "Iniciar Sesión"
- Usa las credenciales registradas
- O usa el usuario de prueba:
  - Email: `prueba@email.com`
  - Contraseña: `123456`

## Características Funcionales 🎯

✓ **Calendario Mensual**
- Ver calendario del mes actual
- Marcar fechas de período
- Predicción de próxima menstruación

✓ **Modo Embarazo**
- Datos simulados de embarazo
- Información del tamaño del bebé
- Registro de síntomas y citas

✓ **Perfil de Usuario**
- Editar información personal
- Actualizar avatar
- Guardar biografía

✓ **API REST**
- `periodo.php` : GET/POST para gestionar fechas

## Estructura de Ficheros 📁

```
mempe/
├── index.php                    (Login/Registro)
├── calendarioAdmin.php          (Dashboard principal)
├── actualizar_perfil.php        (Actualizar datos)
├── periodo.php                  (API REST)
├── logout.php                   (Cerrar sesión)
├── registro.php                 (Alias a index)
├── init_database.php            (Inicializar BD)
├── conexion.php                 (Conexión a BD)
├── css/
│   └── estilos.css             (Estilos CSS)
└── README.md                    (Este archivo)
```

## Requisitos 📋

- XAMPP ejecutándose (Apache + MySQL)
- PHP 7.0+
- MySQL 5.5+
- Navegador moderno

## Usuario de Prueba 👤

**Email:** prueba@email.com
**Contraseña:** 123456

(Se crea automáticamente al ejecutar `init_database.php`)

## Solución de Problemas 🔧

### "Error de conexión: ..."
- Verifica que MySQL esté ejecutándose en XAMPP
- Confirma que la base de datos `mempe` existe
- Ejecuta `init_database.php`

### "No se puede iniciar sesión"
- Verifica que hayas registrado un usuario
- O usa el usuario de prueba
- Verifica que las sesiones PHP estén habilitadas

### "Página en blanco"
- Revisa los logs de PHP en XAMPP
- Verifica que no haya errores de sintaxis
- Confirma que todos los archivos están en `c:\xampp\htdocs\mempe\`

## Notas de Seguridad ⚠️

⚠️ **IMPORTANTE**: Esta versión está optimizada para XAMPP (desarrollo local).
Para producción, implementa:
- Encriptación de contraseñas: `password_hash()` y `password_verify()`
- HTTPS obligatorio
- Protección CSRF
- Validación más estricta
- Preparar todas las consultas SQL

## Contacto y Soporte

Si encuentras problemas, verifica:
1. Que XAMPP esté corriendo correctamente
2. Que MySQL tenga la base de datos `mempe`
3. Que ejecutaste `init_database.php`
4. Los logs de PHP/MySQL

---
**Versión:** 2.0 Corregida
**Fecha:** 15 de Abril de 2026

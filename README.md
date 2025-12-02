# clubDePadel
Sistema completo de gestión para club de pádel con autenticación de usuarios, roles (admin/usuario), y CRUD de usuarios, pistas y reservas. Base de datos MySQL con validaciones de disponibilidad, sesiones PHP para control de acceso, y funciones de hash para contraseñas. Interfaz web responsiva con CSS moderno.

SISTEMA DE GESTION DE CLUB DE PADEL - PHP CON MYSQL Y SISTEMA DE ROLES

Aplicacion web completa desarrollada en PHP y MySQL para la gestion integral de un club de padel, implementando sistema de autenticacion, roles de usuario, control de acceso y operaciones CRUD completas. Proyecto profesional que demuestra habilidades en desarrollo web full-stack con base de datos relacional.

ESTRUCTURA DEL PROYECTO

CLUB_DE_PADEL/
├── index.php - Pagina principal de login
├── dashboard_admin.php - Panel de administracion
├── dashboard_usuario.php - Panel de usuario normal
├── procesar_login.php - Procesamiento de autenticacion
├── procesar_usuario.php - Gestion de usuarios
├── procesar_pista.php - Gestion de pistas
├── procesar_reserva.php - Gestion de reservas
├── logout.php - Cierre de sesion
├── includes/ - Componentes y funciones
│ ├── config.php - Configuracion de conexion BD
│ ├── functions.php - Funciones principales
│ ├── header.php - Cabecera de la aplicacion
│ ├── footer.php - Pie de pagina
│ ├── modificar_usuario.php - Formulario modificacion
│ ├── modificar_pista.php - Formulario modificacion
│ └── modificar_reserva.php - Formulario modificacion
├── db/ - Scripts de base de datos
│ └── script_creacion_tablas.sql
└── assets/ - Recursos estaticos
└── style.css - Estilos CSS

ARQUITECTURA DE BASE DE DATOS

BASE DE DATOS: padel

TABLAS:

USUARIO

id_usuario: INT, AUTO_INCREMENT, PRIMARY KEY

nombre: VARCHAR(255), UNIQUE

pass: VARCHAR(255) - Contraseñas hasheadas

tipo: INT (0=Administrador, 1=Usuario Normal)

PISTA

id_pista: INT, AUTO_INCREMENT, PRIMARY KEY

nombre: VARCHAR(255)

RESERVA

id_reserva: INT, AUTO_INCREMENT, PRIMARY KEY

usuario: INT, FOREIGN KEY (USUARIO.id_usuario)

pista: INT, FOREIGN KEY (PISTA.id_pista)

turno: VARCHAR(50) - Valores: Mañana, Tarde, Noche

USUARIO DE CONEXION:

Usuario: 'club_padel'@'localhost'

Contraseña: 'PadelSecure123!'

Permisos: SELECT, INSERT, UPDATE, DELETE en base de datos padel

FUNCIONALIDADES PRINCIPALES

SISTEMA DE AUTENTICACION

Login seguro con validacion de credenciales

Hash de contraseñas con password_hash()

Session management con PHP

Control de acceso por roles

Logout seguro

PANEL DE ADMINISTRACION (Tipo 0)

Gestion completa de usuarios (CRUD)

Gestion completa de pistas (CRUD)

Gestion completa de reservas (CRUD)

Visualizacion de todas las reservas del sistema

Borrado masivo de reservas

PANEL DE USUARIO (Tipo 1)

Visualizacion de reservas propias

Creacion de nuevas reservas

Cancelacion de reservas propias

Validacion de disponibilidad de pistas

SISTEMA DE RESERVAS

Validacion de pista disponible por turno

Prevencion de doble reserva en mismo turno

Turnos disponibles: Mañana, Tarde, Noche

Integridad referencial con claves foraneas

CARACTERISTICAS DE SEGURIDAD

SEGURIDAD EN AUTENTICACION:

Contraseñas almacenadas con password_hash()

Verificacion con password_verify()

Sesiones PHP con validacion de estado

Prevencion de acceso directo a archivos

PROTECCION DE DATOS:

Sanitizacion de entradas con htmlspecialchars()

Consultas preparadas con mysqli_prepare()

Validacion de tipos de datos

Prevencion de SQL injection

CONTROL DE ACCESO:

Middleware de autenticacion en cada pagina

Verificacion de roles antes de operaciones

Redireccion a login si no autenticado

Usuarios normales solo acceden a sus datos

MANEJO DE ERRORES:

Mensajes de error y exito claros

Confirmaciones JavaScript para acciones criticas

Validacion en cliente y servidor

Logout automatico por seguridad

FUNCIONES PHP IMPLEMENTADAS

FUNCIONES DE AUTENTICACION:

login_usuario($usuario, $contrasena)

Validacion contra base de datos

Manejo de sesiones

FUNCIONES DE USUARIOS:

crear_usuario($nombre, $pass, $tipo)

modificar_usuario($id_usuario, $nombre, $pass, $tipo)

borrar_usuario($id_usuario)

mostrar_usuarios()

FUNCIONES DE PISTAS:

crear_pista($nombre)

modificar_pista($id_pista, $nombre)

borrar_pista($id_pista)

mostrar_pistas()

FUNCIONES DE RESERVAS:

crear_reserva($usuario, $pista, $turno)

modificar_reserva($id_reserva, $usuario, $pista, $turno)

borrar_reserva($id_reserva)

pista_disponible($pista, $turno)

mostrar_reservas()

mostrar_mis_reservas($id_usuario)

FLUJO DE LA APLICACION

ACCESO INICIAL:

Usuario accede a index.php

Sistema verifica si ya tiene sesion activa

Si no tiene sesion: muestra formulario login

Si tiene sesion: redirige segun su rol

PROCESO DE LOGIN:

Usuario ingresa nombre y contraseña

Sistema valida credenciales en BD

Si correcto: crea sesion y redirige

Si incorrecto: muestra error

PANEL DE ADMINISTRACION:

Gestión de usuarios: crear, modificar, borrar

Gestión de pistas: crear, modificar, borrar

Gestión de reservas: ver todas, borrar

Acceso a modificación de registros

PANEL DE USUARIO:

Ver reservas propias

Crear nueva reserva con validación

Cancelar reservas propias

Solo acceso a datos personales

OPERACIONES CRUD:

CREATE: Inserción con validación

READ: Consulta con joins para datos relacionados

UPDATE: Modificación con permisos verificados

DELETE: Borrado con confirmación

VALIDACIONES IMPLEMENTADAS

VALIDACION DE FORMULARIOS:

Campos requeridos

Unicidad de nombres de usuario

Tipos de datos correctos

Rangos y formatos validos

VALIDACION DE NEGOCIO:

Pista disponible en turno solicitado

Usuario no puede modificar datos ajenos

Administrador puede gestionar todo

Integridad referencial en borrados

VALIDACION DE SEGURIDAD:

Sesion activa y valida

Permisos de rol para operaciones

Prevencion de CSRF (en formularios)

Escape de salidas HTML

INTERFAZ Y EXPERIENCIA DE USUARIO

DISEÑO VISUAL:

CSS moderno con variables personalizadas

Layout responsivo

Colores diferenciados por secciones

Iconos y elementos visuales claros

COMPONENTES DE INTERFAZ:

Tablas con acciones integradas

Formularios con validacion visual

Mensajes flash de exito/error

Botones de accion claramente diferenciados

NAVEGACION:

Menu de navegacion segun rol

Breadcrumbs visuales

Botones de retorno claros

Indicadores de estado

FEEDBACK AL USUARIO:

Mensajes de confirmacion

Indicadores de carga

Validacion en tiempo real

Ayudas contextuales

INSTALACION Y CONFIGURACION

REQUISITOS DEL SISTEMA:

Servidor web (Apache, Nginx)

PHP 7.4 o superior

MySQL 5.7 o superior

Extensiones PHP: mysqli, session

CONFIGURACION DE BASE DE DATOS:

Crear usuario 'club_padel' con contraseña

Asignar permisos SELECT, INSERT, UPDATE, DELETE

Crear base de datos 'padel'

Ejecutar script de creacion de tablas

CONFIGURACION DE LA APLICACION:

Subir archivos al servidor web

Configurar conexion en includes/config.php

Ajustar permisos de archivos y directorios

Configurar rutas si es necesario

USUARIO INICIAL:

Ejecutar script de insercion de usuario admin

Credenciales por defecto en documentacion

Cambiar contraseña despues del primer acceso

SCRIPT SQL DE CREACION

sql
CREATE DATABASE padel;
USE padel;

CREATE TABLE USUARIO (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) UNIQUE,
    pass VARCHAR(255),
    tipo INT
);

CREATE TABLE PISTA (
    id_pista INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255)
);

CREATE TABLE RESERVA (
    id_reserva INT AUTO_INCREMENT PRIMARY KEY,
    usuario INT,
    pista INT,
    turno VARCHAR(50),
    FOREIGN KEY (usuario) REFERENCES USUARIO(id_usuario),
    FOREIGN KEY (pista) REFERENCES PISTA(id_pista)
);
HABILIDADES DEMOSTRADAS

DESARROLLO BACKEND:

Programacion PHP orientada a procedimientos

Gestion de sesiones y estado

Consultas SQL avanzadas con joins

Validacion y sanitizacion de datos

BASE DE DATOS:

Diseño de esquema relacional

Claves primarias y foraneas

Consultas preparadas y parametrizadas

Gestion de usuarios y permisos MySQL

SEGURIDAD WEB:

Autenticacion y autorizacion

Hash de contraseñas

Prevencion de inyeccion SQL

Control de acceso por roles

FRONTEND Y UX:

HTML semantico y accesible

CSS moderno y responsivo

Formularios interactivos

Mensajeria de usuario

ARQUITECTURA DE SOFTWARE:

Separacion de responsabilidades

Reutilizacion de codigo

Estructura de directorios organizada

Configuracion externalizada

CASOS DE USO EJEMPLO

CASO 1: ADMINISTRADOR CREA USUARIO

Accede a dashboard_admin.php

Completa formulario de nuevo usuario

Sistema valida unicidad del nombre

Crea usuario con contraseña hasheada

Muestra mensaje de confirmacion

CASO 2: USUARIO HACE RESERVA

Accede a dashboard_usuario.php

Selecciona pista y turno disponibles

Sistema valida que pista este libre

Crea reserva en base de datos

Muestra confirmacion en panel

CASO 3: CONFLICTO DE RESERVA

Usuario intenta reservar pista ocupada

Sistema detecta conflicto

Muestra mensaje de error especifico

Sugiere otros turnos disponibles

EXTENSIONES Y MEJORAS POSIBLES

FUNCIONALIDADES AVANZADAS:

Sistema de pagos integrado

Calendario visual de reservas

Notificaciones por email

Reportes y estadisticas

SEGURIDAD MEJORADA:

Recuperacion de contraseña

Verificacion de email

Logs de actividad

Autenticacion de dos factores

INTERFAZ MEJORADA:

Aplicacion movil responsive

API REST para integraciones

Panel de administracion mas completo

Temas personalizables

ESCALABILIDAD:

Caché de consultas frecuentes

Base de datos replicada

Balanceo de carga

Sistema de colas para reservas

PUNTOS DESTACADOS DEL PROYECTO

ARQUITECTURA ROBUSTA:

Separacion clara de capas

Codigo modular y reutilizable

Configuracion externalizada

Manejo de errores consistente

SEGURIDAD INTEGRAL:

Practicas OWASP implementadas

Defensa en profundidad

Validacion en multiples niveles

Seguridad por defecto

EXPERIENCIA DE DESARROLLO:

Codigo bien documentado

Estructura clara y mantenible

Convenciones de codigo consistentes

Facil de extender y modificar

CALIDAD DEL CODIGO:

Funciones con responsabilidad unica

Nombre de variables descriptivos

Comentarios explicativos donde necesario

Codigo limpio y organizado

NOTAS DEL DESARROLLADOR

Este proyecto representa una aplicacion web completa y profesional que demuestra competencias tecnicas esenciales para desarrollo full-stack:

Capacidad para diseñar e implementar sistemas complejos

Habilidad para trabajar con bases de datos relacionales

Conocimiento profundo de seguridad web

Experiencia en creacion de interfaces de usuario funcionales

Comprension de patrones de arquitectura web

El sistema esta diseñado siguiendo mejores practicas de la industria y puede servir como base para sistemas de gestion mas complejos o como ejemplo de portafolio para oportunidades laborales.

AUTOR: Luis Enrique Molina Moreno
CONTACTO: le.molina87@outlook.com
LICENCIA: MIT
VERSION: 1.0
FECHA: 2025

# 📦 Sistema de Gestión de Compras y Pagos - Proyecto N°7L

[![Laravel](https://img.shields.io/badge/Laravel-12.x-E33B2E?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Vite](https://img.shields.io/badge/Vite-7.x-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![Select2](https://img.shields.io/badge/Select2-Dropdowns-blue?style=for-the-badge&logo=jquery&logoColor=white)](https://select2.org)

Este es un sistema web integral diseñado para la administración, control y registro de compras, proveedores, inventario de productos y flujo de pagos. El proyecto está construido bajo una arquitectura robusta, segura y escalable, utilizando el framework **Laravel 12**, **Vite** y base de datos relacional.

---

## 🚀 Demo en la Nube

El proyecto se encuentra desplegado y listo para su uso en producción:

🔗 **Link del Proyecto en Render:** [https://proyecto-bz8p.onrender.com](https://proyecto-bz8p.onrender.com)

---

## 🏛️ Arquitectura del Servidor & Seguridad en la Nube (Explicación para Exposición)

Un aspecto clave de este proyecto es su diseño orientado a la **seguridad informática** y **aislamiento de datos** en producción utilizando **Render.com**.

```
[ Internet (Usuarios) ]
       │
       ▼
┌───────────────────────────────────────────────┐
│              SERVIDOR DE RENDER               │
│                                               │
│  📁 proyecto/ (Raíz Oculta e Inaccesible)     │
│  ├── 📁 app/                                  │
│  ├── 📁 config/                               │
│  ├── 📁 database/                             │
│  ├── 📄 .env (¡No existe en el Servidor!)      │
│  │                                            │
│  └── 📁 public/  ◄─── [PUNTO DE ENTRADA ÚNICO] │
│      ├── 📄 index.php                         │
│      └── 📁 assets/                           │
└───────────────────────────────────────────────┘
```

### 🔒 1. Aislamiento de Código mediante Directorio Público (`/public`)
* **¿Cómo funciona?** Render está configurado para que su directorio de publicación principal (Document Root) apunte **exclusivamente** a la carpeta `/public` del proyecto.
* **Seguridad:** El navegador de los usuarios solo tiene visibilidad de lo que se encuentra dentro de `/public`. Todo el código crítico (`app/`, `config/`, `database/`, etc.) está ubicado un nivel arriba (`../`).
* **Protección contra intrusiones:** Cualquier intento de acceder a rutas sensibles desde la URL (como `https://proyecto-bz8p.onrender.com/.env` o `https://proyecto-bz8p.onrender.com/app/Models/User.php`) devolverá inmediatamente un **Error 404 (Not Found)**. Los archivos están físicamente fuera del alcance del servidor web.

### 🛡️ 2. Gestión de Credenciales Seguras (Variables de Entorno)
* **Sin archivos .env en el código:** El archivo `.env` que almacena contraseñas y credenciales sensibles está en el `.gitignore` y **nunca** se sube a GitHub ni a la nube.
* **Seguridad de Render:** Las llaves de acceso, credenciales de base de datos PostgreSQL y llaves de cifrado están inyectadas a nivel de memoria del contenedor mediante el menú **Environment Variables** en el panel de control de Render, garantizando que nadie que tenga acceso al código fuente pueda comprometer la seguridad del sistema o de la base de datos.

---

## 🛠️ Características Principales del Sistema

* **🛡️ Autenticación y Perfiles:** Registro e inicio de sesión de usuarios con personalización de perfil y foto.
* **🚚 Gestión de Proveedores:** Registro completo y visualización de proveedores activos/inactivos.
* **📦 Control de Inventario Inteligente (Productos):**
  * Configuración de **Stock actual** y **Stock máximo**.
  * Carga y previsualización dinámica de imágenes de productos.
  * **Control de Stock No Negativo:** El sistema impide transacciones que puedan resultar en un inventario negativo.
* **🛒 Órdenes de Compra Automatizadas:**
  * Cálculo en tiempo real de subtotales, abonos y saldos pendientes.
  * Flujo según el tipo de pago: **Contado** (abona el total automáticamente) o **Crédito** (permite abonos parciales y registra saldos pendientes).
  * Deducción de stock automática inmediata al confirmar la transacción.
* **💳 Gestión de Pagos:** Control de saldos e historial de pagos asociados a sus respectivas órdenes de compra.
* **🔍 Formularios Select2 Modernos:** Los desplegables de búsqueda (productos, proveedores, órdenes, etc.) cuentan con la tecnología **Select2** para búsquedas instantáneas y filtros avanzados.
* **📤 Reportes y Exportación:**
  * Descarga de listados de productos, proveedores y pagos a formatos compatibles con **Excel (CSV)**.
  * Generación dinámica de vistas limpias para impresión y exportación en **PDF**.

---

## 🚀 Guía de Instalación y Ejecución Local

### Prerrequisitos
* PHP >= 8.2 (incluido en XAMPP)
* Composer
* Node.js & npm

### Pasos para Configuración Local

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/SernaJav/proyecto.git
   cd proyecto
   ```

2. **Instalar dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Frontend (Vite, Select2, Bootstrap):**
   ```bash
   npm install
   ```

4. **Configurar el archivo `.env` local:**
   Renombra el archivo de ejemplo a `.env` y configura tus variables locales (Base de datos MySQL de XAMPP o SQLite).
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```

5. **Para correr el sistema localmente con Vite (Live Reloading):**
   ```bash
   composer run dev
   ```
   *Este comando iniciará el servidor de Laravel en `http://127.0.0.1:8000` y el servidor de Vite en el puerto `5173` de forma simultánea.*

6. **Para compilar de manera estática y servir con XAMPP (Apache):**
   ```bash
   npm run build
   ```
   *Una vez compilado, puedes ingresar directamente a `http://localhost/proyecto/public` desde tu navegador sin consolas abiertas.*

---

## 📄 Licencia

Este proyecto es software de código abierto protegido bajo la licencia [MIT](https://opensource.org/licenses/MIT).

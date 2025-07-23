# Survey App (Laravel)

Este proyecto es una API REST desarrollada con **Laravel 12**, diseñada para gestionar la autenticación de usuarios y recopilar información a través de una encuesta. La autenticación se gestiona mediante **Laravel Sanctum**, la cual permite proteger las rutas y asegurar las interacciones con los usuarios registrados.

## 🔍 Descripción general

La API permite:

- Registrar y autenticar usuarios.
- Obtener y responder una encuesta diseñada para entender los desafíos operativos en droguerías.
- Consultar las respuestas previamente registradas por el usuario autenticado.

---

## 🚀 Instrucciones para ejecutar el proyecto


### 1. Clonar el repositorio

```bash
    git clone https://github.com/alvarezestefania/Survey-Backend.git
```

### 2. Ir a la carpeta del proyecto

```bash
    cd Survey-Backend
```

### 3. Cambiarse a la rama `develop`

```bash
    git checkout develop
```

### 4. Instalar dependencias con Composer

```bash
    composer install
```

### 5. Copiar archivo `.env` y configurar variables de entorno

```bash
    cp .env.example .env
```

Edita el archivo `.env` y configura tu base de datos:

```env
DB_DATABASE=survey_api
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña
```

### 6. Generar la clave de la aplicación

```bash
    php artisan key:generate
```

### 7. Ejecutar las migraciones

```bash
    php artisan migrate
```

### 8. Ejecutar los seeders para cargar preguntas de ejemplo

```bash
    php artisan db:seed
```

### 9. Levantar el servidor de desarrollo

```bash
    php artisan serve
```

## 🧪 Ejecutar pruebas unitarias

Este proyecto utiliza PHPUnit para las pruebas unitarias. Las pruebas están disponibles en la rama develop. Para ajecutar todas las pruebas, utiliza el siguiente comando:

```bash
    php artisan test
```

---

## 🧠 Notas adicionales

- Las funcionalidades están organizadas en ramas de feature (`feat/auth`, `feat/survey`) y luego integradas en `develop`.
- La rama `master` se mantiene limpia como rama base.

---

## 🧑‍💻 Autor

Estefania Alvarez  


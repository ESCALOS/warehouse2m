# Almacén Agrícola 2M

## Descripción

Aplicación web para un correcto gestionamiento del almacen de la agrícola 2M.

## Requerimientos del Sistema

Asegúrate de tener instalados los siguientes componentes antes de ejecutar el proyecto.

### Servidor Web

El proyecto requiere un servidor web compatible, como Apache o Nginx. Asegúrate de tener configurado tu servidor web correctamente.

### PHP

El proyecto necesita PHP en tu sistema. Se recomienda PHP 8.2 o superior. Puedes instalar PHP siguiendo las instrucciones en el [sitio oficial de PHP](https://www.php.net/manual/en/install.php).

#### Extensiones PHP

Asegúrate de habilitar las siguientes extensiones en tu archivo de configuración `php.ini`:

- `gd`
- `zip`

### Composer

Composer es necesario para manejar las dependencias de PHP. Puedes instalar Composer siguiendo las instrucciones en [getcomposer.org](https://getcomposer.org/download/).

### Node.js y npm

El proyecto utiliza Node.js y npm para gestionar dependencias de frontend y scripts. Puedes instalar Node.js y npm desde [nodejs.org](https://nodejs.org/).

## Instalación

Sigue estos pasos para instalar y configurar el proyecto localmente:

1. **Clona el repositorio:**

    ```bash
    git clone https://github.com/tu-usuario/tu-proyecto.git

2. **Instala las dependencias de PHP utilizando Composer:**

    ``` bash
    composer install
3. **Instala las dependencias de Node.js:**
    
    ```bash
    npm install
4. **Copia el archivo .env.example y renómbralo a .env. Configura las credenciales de la base de datos y otras configuraciones necesarias en el archivo .env.**

5. **Genera la clave de la aplicación:**

    ```bash
    php artisan key:generate

6. **Ejecuta las migraciones de la base de datos y siembra datos de prueba:**

    ```bash
    php artisan migrate --seed

7. **Inicia el servidor de desarrollo:**

    ```bash
    php artisan serve

El servidor estará disponible en http://localhost:8000.

## Notas Adicionales

Asegúrate de que tu servidor web esté correctamente configurado para dirigir las solicitudes al directorio público del proyecto.

Recuerda ajustar la configuración de permisos de los archivos y directorios según sea necesario para tu entorno.

¡Listo! Tu aplicación Laravel debería estar ahora disponible y funcionando en tu entorno local.

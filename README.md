## Cómo instalar el proyecto

La forma más sencilla de ejecutar el proyecto es utilizando [Sail](https://laravel.com/docs/10.x/sail) que es un entorno de desarrollo local para Laravel utilizando Docker.
Debemos tener instalado [Docker](https://www.docker.com/products/docker-desktop) en nuestra máquina.
Debemos de tener instalada la versión 8.3 o mayor de PHP y Composer.

Los pasos son los siguientes:
1. Abrir bash en la raíz del proyecto
2. Crear un archivo .env en la raíz del proyecto con la información del archivo .env.example
3. En nuestro archivo .env debemos de configurar las variables de entorno para el envío de correos electrónicos
2. Ejecutar el comando `'composer install'`
2. Crear un alias con el comando `alias sail='bash vendor/bin/sail'`
3. Ejecutar el comando `sail up -d`
4. Ejecutar el comando `sail artisan migrate`
5. Ejecutar el comando `sail artisan db:seed`
6. Iniciar los workers con el comando `sail artisan queue:work`
7. Abrir nuestro sitio en la url `http://localhost`

De forma alternativa podemos ejecutar el proyecto sin sail ejecutando los pasos anteriores sin usar el prefijo sail
para los comandos y creando una base de datos local de la cuál pondremos las credenciales en nuestras variables de entorno.

La documentación de la API se encuentra en [https://documenter.getpostman.com/view/8450870/2sA2xcbvYP](https://documenter.getpostman.com/view/8450870/2sA2xcbvYP).
Recomiendo que se haga un fork y se utilice Postman para probar la API ya que Sanctum requiere configuraciones que están hechas en las colleciones.
Las variables de entorno en postman son
- baseUrL: http://localhost/api/v1
- BACK: http://localhost

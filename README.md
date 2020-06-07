# seuFinalProject

Aplicación web para el Proyecto Final de SEU Curso 2019-2020. Universidad Pablo de Olavide

# Instalación

La aplicación web está desarrollada sobre Symfony 3.4, por lo que es necesario una vez descargado el repositorio, instalar los vendor utilizados.

Para ello es necesario ejecutar el comando "composer install"

Una vez instalados los vendors, se deben entrar los parametros de configuración de la API KEY del TalkBack y el ID del TalkBack, email al que se deben enviar
las notificaciones.

Estos parámetros se configuran en config/services.yml

Por último, para poder probar la aplicación localmente sin necesidad de instalar un servidor Apache, se puede descargar el instalador 

de Symfony en: https://get.symfony.com/cli/setup.exe 

Luego en el mismo directorio raiz, ejecutar "symfony server:start"

Deberia estar publica la aplicacion en la direccion http://127.0.0.1:8000

Y el endpoint estaría en http://127.0.0.1:8000/temperature-variation?&mode=low 

El parametro "mode" acepta los valores "low" o "high".

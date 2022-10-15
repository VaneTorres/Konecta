<p align="center"><a href="https://laravel.com" target="_blank"><img
                    src="https://uploads-ssl.webflow.com/62163e8c328ad285342080f0/621642b049155333353ec220_logo.svg"
                    loading="lazy" alt="konecta logo blue" class="brand_logo"></a></p>



## Prueba para Analista de Desarrollo en PHP de Konecta

A continuación, se mostrará los pasos para correr el proyecto:

- Ejecutar composer install
- Crear la base de datos
- Crear un archivo .env igual al que se muestra en .env.example
- De la linea 9 a la 14 del archivo .env se encuentran las variables para configurar la base de datos (DB_CONNECTION, DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- Ejecutar php artisan migrate --seed
- Ejecutar php artisan serve

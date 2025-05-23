# Guia de como levantar todos los servicios relacionados al proyecto web

* git clone <url-repo>
* cd project-name
* composer install
* cp .env.example .env (Editar el .env con los valores deseados)
* phinx migrate
* php -S localhost:8888 -t public/
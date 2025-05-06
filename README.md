# Trabajo Práctico - PAWPrints

## Programación en Ambiente Web

### **Integrantes**

- Buzzo Marcelo, Rocco   |   Legajo: 190292
- Cardona, Eliana        |   Legajo: 118441
- Pereyra Buch, Bautista |   Legajo 193177

## Entrega 1

El proyecto que les proponemos es la Web de una librería (venta de libros) llamada PAWPrints. Las etapas a desarrollar en este TP serán:

- Realizar un SiteMap del Sitio, planteando la jerarquía de las secciones y las páginas.

> ![alt text](/home/images/pawprints-sitemap.png)

- Diseñar wireframes low-fi en Figma para representar las pantallas principales del sitio web.

> Link al [Wireframe](https://www.figma.com/design/iVTO3usGiNgsAN9lrRd9ko/TP1-PAW?node-id=0-1&p=f&t=Weh9avHT0X2SWn6c-0)

- Maquetar el sitio web usando solo HTML5, siguiendo las pautas de los wireframes.
- Demostrar la correcta utilización de los elementos semánticos de HTML5. Refleje en cada sección los tags HTML que mejor consideren que se adaptan al contenido de la página a mostrar.
- Crear un formulario de reserva de libro para demostrar el uso adecuado de los formularios HTML, utilizando los tags y atributos que considere que mejor se adapten al tipo de dato del campo, para facilitar la validación.

> Link al [Repositorio](https://github.com/roccobuzzomarcelo/PAW-2025-TPS/tree/main/home)

## Entrega 3

1) Adoptamos una arquitectura basada en el patrón MVC (Modelo–Vista–Controlador), este patrón nos permite organizar el código de forma modular, separando la lógica de negocio, la presentación y el control de flujo. Además, al diseñar esta arquitectura, consideramos las problemáticas más comunes en el desarrollo de aplicaciones web, incorporando la persistencia de datos inicial en archivos de texto. Este diseño brinda una base sólida para desarrollar nuevas funcionalidades, mantener el sistema ordenado y escalarlo según necesidades futuras.

    | **Componente**     | **Ubicación / Archivo**                        | **Responsabilidad**                                                                 |
    |--------------------|------------------------------------------------|-------------------------------------------------------------------------------------|
    | Front Controller    | public/index.php                               | Punto de entrada del sistema. Recibe todas las peticiones y las redirige al controlador correcto. |
    | Router              | src/Core/Router.php                            | Analiza la URL y determina qué controlador y acción ejecutar.                      |
    | Controladores       | src/App/Controlador/                           | Manejan la lógica de cada sección. Cada archivo representa un controlador.         |
    | Vistas              | src/App/views/*.view.php                       | Plantillas PHP reutilizables que generan la salida HTML del sistema. Separan la presentación de la lógica. |
    | Persistencia        | datos/libros.txt, datos/reservas.txt          | Archivos planos que simulan una base de datos. Pueden ser leídos/escritos por los controladores. |
    | Logs                | logs/app.log                                   | Archivo donde se registran eventos, errores o acciones importantes del sistema.    |
    | Assets e Imágenes   | public/images/, public/assets/                | Recursos estáticos del sitio web, como imágenes, CSS o scripts JS (cuando se incorporen). |
    | Dependencias        | composer.json                                  | Define las dependencias externas del proyecto (si las hubiera), gestionadas con Composer. |

2) En la página de inicio de PAWPrints se muestra un menú de navegación que redirige a las secciones más relevantes del sitio web. El menú se genera dinámicamente a través de un array en el controlador ControladorPagina, y cada enlace de menú se asocia a una URL específica en el enrutador. Este router, gestiona las rutas y las redirige a los métodos correspondientes. El uso de rutas permite que el sitio sea escalable, ya que nuevas secciones y funcionalidades se pueden agregar fácilmente al enrutador sin modificar las rutas existentes.

3)
    - La base de datos de libros se implementa en archivos planos que simulan una base de datos.
    - Se desarrolló una funcionalidad que permite listar y buscar libros dentro del catálogo de la librería. La información de los libros se encuentra en el archivo libros.txt,  la lógica de procesamiento está centralizada en el método obtenerLibros del controlador. Este método lee el archivo, filtra por texto (título o autor) si se pasa una consulta y por IDs si se solicitan libros específicos. El formulario utiliza el método HTTP GET, lo que permite que la consulta se refleje en la URL y sea fácilmente compartible o indexable por motores de búsqueda. Además, al tratarse de una operación de solo lectura, GET es el método más apropiado porque es una operación segura y no modifica el estado del servidor, permite compartir fácilmente resultados de búsqueda mediante la URL.

4) Se implementó la funcionalidad que permite al usuario realizar la reserva de un libro a través de un formulario, se genera a través del método reservarLibro(), que obtiene los datos del libro a partir del parámetro id recibido por URL (GET) y se hace el envío con el método POST ya que los datos son sensibles y no deben mostrarse en la URL, se espera que el envío modifique el estado del servidor, ya que registra una reserva. Los datos ingresados por el usuario se procesan en el servidor, aplicando las mismas validaciones que en el archivo html, ademas, se aplica htmlspecialchars() y otras validaciones para prevenir vulnerabilidades, estos datos se almacenan en un archivo de texto (reservas.txt) y se notifica por correo electrónico.

5) Ante la posibilidad de errores en tiempo de ejecución, la aplicación fue diseñada para comportarse de manera segura y controlada, la lógica de manejo de errores está centralizada en un controlador de errores con los métodos notFound() se ejecuta cuando la URL solicitada no coincide con ninguna de las rutas registradas en el sistema y errorInterno() se invoca ante errores internos no previstos durante la ejecución de la aplicación. Ambas funciones cargan vistas separadas (404.view.php y 500.view.php) que presentan mensajes genéricos al usuario, asegurando que no se revelen detalles como trazas de error, nombres de archivos o configuraciones internas del servidor. En el router, al no encontrar una ruta válida para una solicitud, se lanza una excepción personalizada garantizando un flujo de control adecuado sin exponer mensajes del sistema.

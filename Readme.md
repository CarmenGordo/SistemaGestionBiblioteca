Explicacion y capturas de las imagenes de este poyecto: 

Bd creado en un contenedor de Docker "LAMP2" con phpMyAdmin, que es donde se creará la bd y a la cual se le haran las llamadas; por tanto la carpeta con las sentencias a la bd estaran puestas en la carpeta interna /app del contenedor. La contraseña: Emis0KbKa4G3


DENTRO DE LA CARPETA APP: 
    - crearemos las sentencias sql en php para hacer la llamada a la bd que posteriormente usaremos 
    - su estructura será:
        + SistemaGestionBiblioteca: 
            + capturas
            + ConexionBD.php : es la conexion a la bd
            + crud : es la carpeta con el crud del modelo
                + Leer.php
                + Anadir.php
                + Editar.ph
                + Borrar.php
            + Libro.php  : es el modelo
            + Readme.md



PASOS A SEGUIR:

1. Creacion de la bd con la tabla y param especificados (cap1)


2. Comprobar que tenemos descargado npm y Node.js:  node -v   npm -v
    - Si no, descargar con Brew:    brew install node
    - verificar instalacion:     node -v    npm -v

    (en mi caso, como no lo tenia descargado, procedi a ello)


3. Iniciar Node.js en el proyecto:    npm init -y   (cap2)


4. Abrir n8n con:   n8n start  o  npx n8n   (cap4-5)  
    - si no, para descargarlo con:    npm install n8n (cap3)


5. Apertura del navegador, introducir datos y dar a "Credenciales". Crear una credencial con: el tipo y la info del contendeor de Docker (cap6-8).
    - Crear la primera credencial con los datos del contedor (cap9-10)


6. Crear un Flujo de Trabajo o Workflows. Dandole a "Create" se podrá crear uno. 
    - crear las solicitudes de MySQL, para hacer llamadas desde esta interfaz gráfica, dependiendo de cada sentencia se necesitaran x datos (cap)
    - cambiaremos el nombre del flujo, que será el mismo que el del proyecto


7. Crearemos el eje del libro en "Edit  Fields", aqui lo pondremos con formato Json, poniendo los datos que queremos. Si los datos de eje estan bien, al darle a "Test Step", nos dará el visto bueno mediante un "Output" que aparecerá a su lado (cap11-12)


8. Para AÑADIR:
   - crear la solicitud de sql, buscandola en el menu de la derecha(cap13)
   - seleccionar el tipo de sentencia, en nuestro caso será de INSERT
   - se le asigna la bd, el tipo de operacion y la tabla (cap14)
   - probaremos a insertar este libro y lo veremos en la bd (cap15)

   - crearemos su entrada con HTTP Rquest, buscandolo en el menu lateral: una vez dentro le donde le diremos el tipo de metodo, la ruta al archivo correspondiente y su sentencia Json para añadir (cap16-17)
   - para comprobarlo se le dará a "Test step" (cap18)
   - comprobaremos que se ha añadido (cap19)


9. Para LEER:
    - crearemos su sentencia sql, de la misma manera, pero eligiendo el metodo a usar, si no le decimos param devolverá todo (cap20)
    - agregaremos param para ver solo aquel con titulo "El Principito" (cap21)

    - crearemos su HTTP Request, correspondiendo a su archivo en el crud
    - comprobamos que si no le ponemos param nos devuelve todos (cap22)
    - si no nos devolverá aquel con el titulo "El Resplandor" (cap23)


A partir de ahora usaremos los SET, para definir los datos, estos los usaremos en los dos ultimos metodos del crud, para verlos:

10. Para EDITAR:
    - crearemos su sentencia sql, con el metodo post
    - editaremos aquel con el titulo "El Principito"
    - editaremos por su id (cap)


11. Para BORRAR:

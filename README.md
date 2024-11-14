## Estructura del proyecto

- **db.php**: Configuración de la conexión a la base de datos.
- **index.php**: Archivo principal que maneja las solicitudes HTTP y enrutamiento a los métodos de producto.
- **product.php**: Contiene la lógica de CRUD para productos en la base de datos.
- **interface.php**: Interfaz web para interactuar visualmente con los productos.
- **Dockerfile**: Archivo de configuración para crear una imagen Docker de PHP con MySQL.
- **docker-compose.yml**: Orquestador que define los servicios necesarios: MySQL y PHP.


## Requisitos previos

- Docker
- Docker Compose

## Instalación y Ejecución

1. Clona el repositorio en tu máquina local.
2. Navega a la carpeta del proyecto.
3. Ejecuta el siguiente comando para iniciar los contenedores Docker:

    ```bash
    docker-compose up
    ```

   Este comando iniciará los servicios definidos en `docker-compose.yml`. El contenedor MySQL se ejecutará en el puerto 3306 y el contenedor de PHP en el puerto 8080.


4. Accede a la aplicación en tu navegador en [http://localhost:8080/interface.php] para ver la interfaz de administración de productos.

## Endpoints de la API

La API está construida sobre `index.php` y sigue un diseño REST. Los recursos se gestionan a través de `/index.php?resource=products`.

********************************************************
            ***********************************
##              Obtener Todos los Productos
            ***********************************
### GET `/index.php?resource=products`
## Obtiene la lista de todos los productos.

## Ejemplo de solicitud
## json Metodo Get
[
    {
        "name": "Producto 10",
        "price": 100,
        "description": "Descripción del producto 10"
    },
]

**********************************************************
                *******************************
##                  Obtener Producto por ID
                *******************************
### GET `/index.php?resource=products&id=3`
## Obtiene la información de un producto específico mediante su id.

## Ejemplo de solicitud
## json Metodo GET por id 
{
    "id": 1,
    "name": "Producto 1",
    "description": "Descripción del producto 1",
    "price": 100.0
}

***********************************************************
                *******************************
##                  Crear un Nuevo Producto
                *******************************
### POST `/index.php?resource=products`
## Crea un nuevo producto en la base de datos.

## Ejemplo de solicitud
## json Metodo POST
{
    "name": "Nuevo Producto",
    "description": "Descripción del nuevo producto",
    "price": 200.0
}

*************************************************************
                ******************************
##                  Actualizar un Producto
                ******************************
### PUT `index.php?resource=products&id=2`
## Actualiza la información de un producto existente.

## Ejemplo de solicitud
## json Metodo PUT
{
  "name": "Coca Cola",
  "description": "Nueva descripción Coca Cola",
  "price": 18.0
}

**************************************************************
                ***************************
##                  Eliminar un Producto
                ***************************
## DELETE `/index.php?resource=products&id=6`
## Elimina un producto existente de la base de datos.

## Ejemplo de solicitud
## json Metodo DELETE
{
    "message": "Product deleted successfully"
}

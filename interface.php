<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Productos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="mt-4 mb-4 text-center">Administración de Productos</h1>

    <!-- Formulario para agregar o editar producto -->
    <div class="card mb-4">
        <div class="card-header">Agregar o Editar Producto</div>
        <div class="card-body">
            <form id="productForm">
                <input type="hidden" id="productId">
                <div class="form-group">
                    <label for="name">Nombre del Producto</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control" id="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="price" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Tabla para listar productos -->
    <div class="card">
        <div class="card-header">Lista de Productos</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="productTable"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
    loadProducts();

    // Cargar productos
    function loadProducts() {
        $.ajax({
            url: 'index.php?resource=products',
            type: 'GET',
            success: function(data) {
                $('#productTable').empty();
                data.forEach(function(product) {
                    $('#productTable').append(`
                        <tr>
                            <td>${product.id}</td>
                            <td>${product.name}</td>
                            <td>${product.description}</td>
                            <td>${product.price}</td>
                            <td>
                                <button class="btn btn-info btn-sm edit-btn" data-id="${product.id}">Editar</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Eliminar</button>
                            </td>
                        </tr>
                    `);
                });
            }
        });
    }

    // Crear o actualizar producto
    $('#productForm').submit(function(e) {
        e.preventDefault();

        let id = $('#productId').val();
        let name = $('#name').val();
        let description = $('#description').val();
        let price = $('#price').val();

        let method = id ? 'PUT' : 'POST';
        let url = id ? `index.php?resource=products&id=${id}` : 'index.php?resource=products';

        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify({ name, description, price }),
            success: function(response) {
                alert(response.message);
                $('#productForm')[0].reset();
                $('#productId').val('');
                loadProducts();
            }
        });
    });

    // Editar producto
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');

        $.ajax({
            url: `index.php?resource=products&id=${id}`,
            type: 'GET',
            success: function(product) {
                $('#productId').val(product.id);
                $('#name').val(product.name);
                $('#description').val(product.description);
                $('#price').val(product.price);
            }
        });
    });

    // Eliminar producto
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            $.ajax({
                url: `index.php?resource=products&id=${id}`,
                type: 'DELETE',
                success: function(response) {
                    alert(response.message);
                    loadProducts();
                }
            });
        }
    });
});
</script>
</body>
</html>

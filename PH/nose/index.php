<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Gestión de Productos</title>
</head>
<body>
    <h1>Gestión de Productos</h1>
    <form id="productForm">
        <input type="text" name="nombre" placeholder="Nombre del Producto" required>
        <input type="number" name="precio" placeholder="Precio" required>
        <button type="submit">Agregar Producto</button>
    </form>
    
    <table id="productTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Productos cargados por AJAX -->
        </tbody>
    </table>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // Función para cargar productos
            function cargarProductos() {
                $.ajax({
                    url: 'listar_productos.php',
                    type: 'GET',
                    success: function(response) {
                        $('#productTable tbody').html(response);
                    }
                });
            }

            // Llamar a la función para cargar los productos al cargar la página
            cargarProductos();

            // Manejar el envío del formulario para agregar un producto
            $('#productForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'add_product.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        alert(response);
                        cargarProductos();
                    }
                });
            });

            // Manejar la eliminación de un producto
            $(document).on('click', '.delete-btn', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: 'delete_product.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response) {
                        alert(response);
                        cargarProductos();
                    }
                });
            });

            // Manejar la edición de un producto
            $(document).on('click', '.edit-btn', function() {
                const id = $(this).data('id');
                const nombre = prompt("Ingrese el nuevo nombre del producto:");
                const precio = prompt("Ingrese el nuevo precio del producto:");

                if (nombre && precio) {
                    $.ajax({
                        url: 'edit_product.php',
                        type: 'POST',
                        data: { id: id, nombre: nombre, precio: precio },
                        success: function(response) {
                            alert(response);
                            cargarProductos();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>

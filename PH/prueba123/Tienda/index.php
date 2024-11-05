<?php
include 'conexion.php';
$marcas = $conn->query("SELECT id_marca, nombre FROM marcas");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tabla de Productos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <form method="GET" action="">
        <input type="text" name="nombre" placeholder="Nombre">
        <input type="text" name="codigo" placeholder="Código">
        <select name="id_marca">
            <option value="">Seleccione una Marca</option>
            <?php
            $sql = "SELECT * FROM marcas";
            $result = $conn->query($sql);
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id_marca']}'>{$row['nombre']}</option>";
            }
            ?>
        </select>
        <button type="submit">Filtrar</button>
        <button type="button" id="openModalBtn">Agregar Producto</button>
        <button onclick="cargarListaProductos()">Cargar</button>
    </form>

    <table>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Marca</th>
            <th>PDF</th>
            <th>Modificar</th>
            <th>Eliminar</th>
        </tr>
        <p id="lista-productos"></p>
    </table>


    <!-- Ventana Modal para PDF -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('pdfModal')">&times;</span>
            <iframe id="pdfViewer" src="" width="100%" height="500px"></iframe>
        </div>
    </div>

    <!-- Ventana Modal para Agregar Producto -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('myModal')">&times;</span>
            <h2>Agregar Nuevo Producto</h2>
            <form action="add_product.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="codigo">Código:</label>
                    <input type="text" id="codigo" name="codigo" required>
                </div>

                <div class="form-group">
                    <label for="id_marca">Marca:</label>
                    <select id="id_marca" name="id_marca" required>
                        <option value="">Selecciona una marca</option>
                        <?php while ($marca = $marcas->fetch_assoc()): ?>
                            <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="archivo_pdf">Archivo PDF:</label>
                    <input type="file" id="archivo_pdf" name="archivo_pdf" accept=".pdf" required>
                </div>

                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </div>

    <!-- Ventana Modal para Editar Producto -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal')">&times;</span>
            <h2>Modificar Producto</h2>
            <form action="edit_product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="editId" name="id_producto">

                <div class="form-group">
                    <label for="editNombre">Nombre:</label>
                    <input type="text" id="editNombre" name="nombre" required>
                </div>

                <div class="form-group">
                    <label for="editCodigo">Código:</label>
                    <input type="text" id="editCodigo" name="codigo" required>
                </div>

                <div class="form-group">
                    <label for="editIdMarca">Marca:</label>
                    <select id="editIdMarca" name="id_marca" required>
                        <option value="">Selecciona una marca</option>
                        <?php

                        $marcas = $conn->query("SELECT id_marca, nombre FROM marcas");
                        while ($marca = $marcas->fetch_assoc()) {
                            echo "<option value='{$marca['id_marca']}'>{$marca['nombre']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <button type="submit">Modificar Producto</button>
            </form>
        </div>
    </div>


    <script>

        function openPdfModal(base64Data) {
            const iframe = document.getElementById('pdfViewer');
            iframe.src = `data:application/pdf;base64,${base64Data}`;
            document.getElementById('pdfModal').style.display = 'block';
        }


        document.getElementById("openModalBtn").onclick = function () {
            document.getElementById("myModal").style.display = "block";
        };


        function openEditModal(id) {
            fetch(`get_product.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('editId').value = data.id_producto;
                        document.getElementById('editNombre').value = data.nombre;
                        document.getElementById('editCodigo').value = data.codigo;
                        document.getElementById('editIdMarca').value = data.id_marca;
                        document.getElementById('editModal').style.display = "block";
                    } else {
                        alert('No se encontraron datos del producto.');
                    }
                })
                .catch(error => {
                    console.error('Error al obtener el producto:', error);
                });
        }



        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            if (modalId === 'pdfModal') {
                document.getElementById('pdfViewer').src = "";
            }
        }


        window.onclick = function (event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        };

        function eliminarProducto(idProducto) {
            if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {

                window.location.href = `delete_product.php?id=${idProducto}`;
            }
        }

        function cargarListaProductos() {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", "listar_productos.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("lista-productos").innerHTML = xhr.responseText;
                } else {
                    console.error("Error al cargar la lista de productos:", xhr.status, xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error("Error de red.");
            };
            xhr.send();
        }


    </script>
</body>

</html>
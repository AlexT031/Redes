<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link rel="stylesheet" href="style.css">
    <script src="app.js" defer></script>
</head>

<body>
    <div class="container">
        <h1>CRUD</h1>

        <button class="button" onclick="openModal()">Agregar</button>
        


        <h2>Lista de Productos</h2>
        
        <input type="text" id="searchInput" placeholder="Buscar productos...">
        <button class="button" onclick="reloadTable()">Recargar Tabla</button>
        <iframe id="productTable" src="read.php" style="width: 100%; height: 400px; border: none;"></iframe>

        <div id="pdfModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePdfModal()">&times;</span>
                <iframe id="pdfViewer" src="" width="100%" height="500px"></iframe>
            </div>
        </div>


        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal()">&times;</span>
                <h2>Agregar Producto</h2>
                <form action="create.php" method="POST" enctype="multipart/form-data">
                    <label for="nombre">Nombre del producto:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <label for="codigo">Código del producto:</label>
                    <input type="text" id="codigo" name="codigo" required><br><br>

                    <label for="id_marca">Marca del producto:</label>
                    <select id="id_marca" name="id_marca" required>
                        <?php

                        include 'db.php';

                        $sql = "SELECT id_marca, nombre FROM marcas";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {

                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['id_marca'] . "'>" . $row['nombre'] . "</option>";
                            }
                        }

                        $conn->close();
                        ?>
                    </select><br><br>

                    <label for="archivo_pdf">Archivo PDF:</label>
                    <input type="file" id="archivo_pdf" name="archivo_pdf" accept="application/pdf"><br><br>

                    <input type="submit" value="Agregar Producto" class="button">
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
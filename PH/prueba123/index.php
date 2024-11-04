<?php include 'conexion.php'; 
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
        <button id="openModalBtn">Agregar Producto</button>
            <?php include 'modal.php'; ?>

    </form>

    

    <table>
        <tr>
            <th>ID Producto</th>
            <th>Nombre</th>
            <th>Código</th>
            <th>Marca</th>
            <th>PDF</th>
        </tr>
        <?php
        $sql = "SELECT p.id_producto, p.nombre, p.codigo, m.nombre AS marca, p.archivo_pdf
                FROM productos p
                JOIN marcas m ON p.id_marca = m.id_marca";

        $conditions = [];
        if (!empty($_GET['nombre']))
            $conditions[] = "p.nombre LIKE '%" . $_GET['nombre'] . "%'";
        if (!empty($_GET['codigo']))
            $conditions[] = "p.codigo = '" . $_GET['codigo'] . "'";
        if (!empty($_GET['id_marca']))
            $conditions[] = "p.id_marca = '" . $_GET['id_marca'] . "'";

        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id_producto']}</td>";
            echo "<td>{$row['nombre']}</td>";
            echo "<td>{$row['codigo']}</td>";
            echo "<td>{$row['marca']}</td>";
            echo "<td><button onclick=\"openModal('" . $row["archivo_pdf"] . "')\">PDF</button></td>";
            echo "</tr>";
        }
        ?>
    </table>


    <!-- Ventana Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <iframe id="pdfViewer" src=""></iframe>
        </div>
    </div>

    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Agregar Nuevo Producto</h2>
        <form action="add_product.php" method="post" enctype="multipart/form-data">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required><br><br>

            <label for="codigo">Código:</label>
            <input type="text" id="codigo" name="codigo" required><br><br>

            <label for="id_marca">Marca:</label>
            <select id="id_marca" name="id_marca" required>
                <option value="">Selecciona una marca</option>
                <?php while($marca = $marcas->fetch_assoc()): ?>
                    <option value="<?php echo $marca['id_marca']; ?>"><?php echo $marca['nombre']; ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="archivo_pdf">Archivo PDF:</label>
            <input type="file" id="archivo_pdf" name="archivo_pdf" accept=".pdf" required><br><br>

            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</div>

    <script>
        // Función para abrir el PDF en la ventana modal
        function openModal(base64Data) {
            const iframe = document.getElementById('pdfViewer');
            iframe.src = `data:application/pdf;base64,${base64Data}`;
            document.getElementById('pdfModal').style.display = 'block';
        }

        // Función para cerrar la ventana modal
        function closeModal() {
            document.getElementById('pdfModal').style.display = 'none';
            document.getElementById('pdfViewer').src = ""; // Limpia el src para liberar memoria
        }

        // Cierra la ventana modal al hacer clic fuera de la misma
        window.onclick = function (event) {
            const modal = document.getElementById('pdfModal');
            if (event.target === modal) {
                closeModal();
            }
        }

        // Obtener elementos
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModalBtn");
        var span = document.getElementsByClassName("close")[0];

        // Cuando el usuario hace clic en el botón, se abre la modal
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // Cuando el usuario hace clic en la X, se cierra la modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // Cuando el usuario hace clic fuera de la modal, se cierra
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

</body>

</html>
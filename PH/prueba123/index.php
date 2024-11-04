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
        if (!empty($_GET['nombre'])) $conditions[] = "p.nombre LIKE '%" . $_GET['nombre'] . "%'";
        if (!empty($_GET['codigo'])) $conditions[] = "p.codigo = '" . $_GET['codigo'] . "'";
        if (!empty($_GET['id_marca'])) $conditions[] = "p.id_marca = '" . $_GET['id_marca'] . "'";

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
            echo "<td><button onclick=\"openPdfModal('" . $row["archivo_pdf"] . "')\">PDF</button></td>";
            echo "</tr>";
        }
        ?>
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
        // Abrir el modal de PDF
        function openPdfModal(base64Data) {
            const iframe = document.getElementById('pdfViewer');
            iframe.src = `data:application/pdf;base64,${base64Data}`;
            document.getElementById('pdfModal').style.display = 'block';
        }

        // Abrir el modal de agregar producto
        document.getElementById("openModalBtn").onclick = function () {
            document.getElementById("myModal").style.display = "block";
        };

        // Cerrar el modal específico
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            if (modalId === 'pdfModal') {
                document.getElementById('pdfViewer').src = ""; // Limpia el src para liberar memoria
            }
        }

        // Cerrar el modal cuando se hace clic fuera de él
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        };
    </script>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <style>
        /* Estilos básicos de tabla */
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }

        /* Estilos para la ventana modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            position: relative;
            background-color: #fff;
            margin: auto;
            padding: 20px;
            width: 80%;
            max-width: 700px;
            height: 80%;
            display: flex;
            flex-direction: column;
        }
        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
            cursor: pointer;
        }
        iframe {
            flex-grow: 1;
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos</h1>
    <table>
        <thead>
            <tr>
                <th>ID Producto</th>
                <th>Nombre</th>
                <th>Código</th>
                <th>Marca</th>
                <th>PDF</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id_producto"] . "</td>";
                    echo "<td>" . $row["nombre"] . "</td>";
                    echo "<td>" . $row["codigo"] . "</td>";
                    echo "<td>" . $row["id_marca"] . "</td>";
                    // Botón para abrir el PDF en una ventana modal
                    echo "<td><button onclick=\"openModal('" . $row["archivo_pdf"] . "')\">Ver PDF</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No hay productos</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Ventana Modal -->
    <div id="pdfModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <iframe id="pdfViewer" src=""></iframe>
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
        window.onclick = function(event) {
            const modal = document.getElementById('pdfModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
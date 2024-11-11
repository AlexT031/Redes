<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: formularioDeLogin.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Consorcios</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 12px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            text-align: center;
        }
        .add-btn, button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin: 5px;
        }
        .add-btn:hover, button:hover {
            background-color: #45a049;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            max-width: 60%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Gestión de Consorcios</h1>
    <button class="add-btn" onclick="showModalAgregar()">Agregar Nuevo Consorcio</button>
    <button onclick="cargarServicios()">Cargar Tabla</button>
    <button onclick="borrar()">Borrar Tabla</button>
    <button onclick="limpiarFiltros()">Limpiar Filtros</button>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Consorcio</th>
                <th>Empresa de Luz</th>
                <th>Empresa de Agua</th>
                <th>Fecha de Renovación</th>
                <th>PDF</th>
                <th>Acciones</th>
            </tr>
            <tr>
                <td><input type="text" id="filtroId" placeholder="Filtro ID"></td>
                <td><input type="text" id="filtroConsorcio" placeholder="Filtro Consorcio"></td>
                <td>
                    <select id="filtroLuz">
                        <option value="">Todos</option>
                        <option value="Edesur">Edesur</option>
                        <option value="Edenor">Edenor</option>
                        <option value="Epec">Epec</option>
                        <option value="Emsa">Emsa</option>
                    </select>
                </td>
                <td>
                    <select id="filtroAgua">
                        <option value="">Todos</option>
                        <option value="AySA">AySA</option>
                        <option value="ABSA">ABSA</option>
                        <option value="ASSA">ASSA</option>
                        <option value="Sameep">Sameep</option>
                    </select>
                </td>
                <td><input type="date" id="filtroFechaRenovacion"></td>
                <td></td>
                <td></td>
            </tr>
        </thead>
        <tbody id="tablaResultados">
            <!-- Contenido cargado dinámicamente -->
        </tbody>
    </table>

    <!-- Modal para agregar servicio -->
    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalAgregar()">&times;</span>
            <h2>Agregar Servicio</h2>
            <form id="servicioForm" enctype="multipart/form-data">
                <label for="consorcio">Consorcio:</label>
                <input type="text" name="consorcio" required><br>

                <label for="empresa_luz">Empresa de Luz:</label>
                <select name="empresa_luz" required>
                    <option value="Edesur">Edesur</option>
                    <option value="Edenor">Edenor</option>
                    <option value="Epec">Epec</option>
                    <option value="Emsa">Emsa</option>
                </select><br>

                <label for="empresa_agua">Empresa de Agua:</label>
                <select name="empresa_agua" required>
                    <option value="AySA">AySA</option>
                    <option value="ABSA">ABSA</option>
                    <option value="ASSA">ASSA</option>
                    <option value="Sameep">Sameep</option>
                </select><br>

                <label for="fecha_renovacion">Fecha de Renovación:</label>
                <input type="date" name="fecha_renovacion" required><br>

                <label for="pdf">PDF de la Boleta:</label>
                <input type="file" name="pdf" accept="application/pdf" required><br>

                <input type="submit" value="Agregar Servicio">
            </form>
        </div>
    </div>

    <!-- Modal para modificar servicio -->
    <div id="modalModificar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalModificar()">&times;</span>
            <h2>Modificar Servicio</h2>
            <form id="modificarForm">
                <input type="hidden" id="modificarId" name="id">
                
                <label for="modificarConsorcio">Consorcio:</label>
                <input type="text" id="modificarConsorcio" name="consorcio" required><br>

                <label for="modificarLuz">Empresa de Luz:</label>
                <select id="modificarLuz" name="empresa_luz" required>
                    <option value="Edesur">Edesur</option>
                    <option value="Edenor">Edenor</option>
                    <option value="Epec">Epec</option>
                    <option value="Emsa">Emsa</option>
                </select><br>

                <label for="modificarAgua">Empresa de Agua:</label>
                <select id="modificarAgua" name="empresa_agua" required>
                    <option value="AySA">AySA</option>
                    <option value="ABSA">ABSA</option>
                    <option value="ASSA">ASSA</option>
                    <option value="Sameep">Sameep</option>
                </select><br>

                <label for="modificarFechaRenovacion">Fecha de Renovación:</label>
                <input type="date" id="modificarFechaRenovacion" name="fecha_renovacion" required><br>
                
                <input type="submit" value="Guardar Cambios">
            </form>
        </div>
    </div>

    <div id="modalVerPDF" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalVerPDF()">&times;</span>
            <h2>Boleta PDF</h2>
            <iframe id="pdfViewer" width="800px" height="650px"></iframe>
        </div>
    </div>

    <script>
        function showModalAgregar() {
            document.getElementById('modalAgregar').style.display = "flex";
        }

        function hideModalAgregar() {
            document.getElementById('modalAgregar').style.display = "none";
        }

        function showModalModificar() {
            document.getElementById('modalModificar').style.display = "flex";
        }

        function hideModalModificar() {
            document.getElementById('modalModificar').style.display = "none";
        }

        function showModalVerPDF(id) {
            document.getElementById('pdfViewer').src = `ver_pdf.php?id=${id}`;
            document.getElementById('modalVerPDF').style.display = "flex";
        }

        function hideModalVerPDF() {
            document.getElementById('modalVerPDF').style.display = "none";
            document.getElementById('pdfViewer').src = "";
        }

        function cargarServicios() {
            const filtroId = document.getElementById('filtroId').value || '';
            const filtroConsorcio = document.getElementById('filtroConsorcio').value || '';
            const filtroLuz = document.getElementById('filtroLuz').value || '';
            const filtroAgua = document.getElementById('filtroAgua').value || '';
            const filtroFechaRenovacion = document.getElementById('filtroFechaRenovacion').value || '';

            const params = new URLSearchParams();
            if (filtroId) params.append("filtroId", filtroId);
            if (filtroConsorcio) params.append("filtroConsorcio", filtroConsorcio);
            if (filtroLuz) params.append("filtroLuz", filtroLuz);
            if (filtroAgua) params.append("filtroAgua", filtroAgua);
            if (filtroFechaRenovacion) params.append("filtroFechaRenovacion", filtroFechaRenovacion);

            const query = params.toString() ? `?${params.toString()}` : "";

            fetch(`listar.php${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById("tablaResultados").innerHTML = data;
                })
                .catch(error => {
                    console.error("Error al cargar la tabla:", error);
                });
        }

        document.getElementById('servicioForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("agregar.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                    hideModalAgregar();
                    cargarServicios();
                })
                .catch(error => {
                    alert("Error al agregar servicio: " + error);
                });
        });

        document.getElementById('modificarForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("modificar.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    hideModalModificar();
                    cargarServicios();
                })
                .catch(error => {
                    console.error("Error al modificar servicio:", error);
                    alert("Error al modificar servicio.");
                });
        });

        function limpiarFiltros() {
            document.getElementById('filtroId').value = "";
            document.getElementById('filtroConsorcio').value = "";
            document.getElementById('filtroLuz').value = "";
            document.getElementById('filtroAgua').value = "";
            document.getElementById('filtroFechaRenovacion').value = "";
        }

        function borrar() {
            document.getElementById("tablaResultados").innerHTML = "";
        }

        function modificarServicio(id, consorcio, empresa_luz, empresa_agua, fecha_renovacion) {
            document.getElementById('modificarId').value = id;
            document.getElementById('modificarConsorcio').value = consorcio;
            document.getElementById('modificarLuz').value = empresa_luz;
            document.getElementById('modificarAgua').value = empresa_agua;
            document.getElementById('modificarFechaRenovacion').value = fecha_renovacion;
            showModalModificar();
        }

        function eliminarServicio(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este Consorcio?")) {
                fetch("eliminar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({ "id": id })
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                    })
                    .catch(error => {
                        alert("Error al eliminar Consorcio: " + error);
                    });
            }
        }
    </script>
</body>
</html>

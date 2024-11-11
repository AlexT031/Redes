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
    <title>CRUD de Empleados</title>
    <style>
        /* Estilos para el modal de respuesta */
        #modalRespuesta {
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

        #modal-content {
            background-color: #fff;
            color: #333;
            padding: 20px;
            border-radius: 8px;
            max-width: 500px;
            text-align: left;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
        }

        #close-button {
            color: #333;
            font-size: 20px;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            background: none;
            border: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
        }

        table,
        th,
        td {
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

        button {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .add-btn {
            display: block;
            margin: 20px auto;
            padding: 15px;
            background-color: #2196F3;
        }

        .add-btn:hover {
            background-color: #1976D2;
        }

        button {
            margin: 5px;
        }
    </style>
</head>

<body>
    <h1>Gestión de Consorcios</h1>
    <button class="add-btn" onclick="showModalAgregar()">Agregar Nuevo Consorcio</button>
    <button onclick="cargarServicios()">Cargar Tabla</button>
    <button id="borrarTableBtn" onclick="borrar()">Borrar Tabla</button>
    <button onclick="limpiarFiltros()">Limpiar Filtros</button>

    <table>
        <tr>
            <th>ID</th>
            <th>consorcio</th>
            <th>empresa_luz</th>
            <th>empresa_agua</th>
            <th>fecha_renovacion</th>
            <th>PDF</th>
            <th>Acciones</th>
        </tr>
        <tr>
            <td><input type="text" id="filtroId" class="filter-input" placeholder="Filtro ID"></td>
            <td><input type="text" id="filtroNombre" class="filter-input" placeholder="Filtro Nombre"></td>
            <td>
                <select id="filtroEmpresa_luz" class="filter-input">
                    <option value="">Todos</option>
                    <option value="Edesur">Edesur</option>
                    <option value="Edenor">Edenor </option>
                    <option value="Epec">Epec</option>
                    <option value="Emsa">Emsa</option>
                </select>
            </td>
            <td>
                <select id="filtroEmpresa_agua" class="filter-input">
                    <option value="">Todos</option>
                    <option value="AySA">AySA</option>
                    <option value="ABSA">ABSA</option>
                    <option value="ASSA">ASSA</option>
                    <option value="Sameep">Sameep</option>
                </select>
            </td>
            <td><input type="text" id="filtroFecha" class="filter-input" placeholder="Filtro Fecha"></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody id="tablaResultados">
        </tbody>
    </table>





    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalAgregar()">&times;</span>
            <h2>Agregar Servicio</h2>
            <form id="servicioForm" enctype="multipart/form-data" method="POST">
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

                <label for="fecha_renovacion">Fecha de Renovación de Boleta:</label>
                <input type="date" name="fecha_renovacion" required><br>

                <label for="pdf">PDF de la Boleta:</label>
                <input type="file" name="pdf" accept="application/pdf" required><br>

                <input type="submit" value="Agregar Servicio">
            </form>
        </div>
    </div>

    <div id="modalModificar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalModificar()">&times;</span>
            <h2>Modificar Consorcio</h2>
            <form id="modificarForm" method="POST">
                <input type="hidden" id="modificarId" name="id">
                <label for="consorcio">consorcio:</label>
                <input type="text" id="modificarNombre" name="nombre" required><br>
                <label for="empresa_luz">empresa luz:</label>
                <select id="modificarPuesto" name="puesto" required>
                    <option value="Edesur">Edesur</option>
                    <option value="Edenor">Edenor</option>
                    <option value="Epec">Epec</option>
                    <option value="Emsa">Emsa</option>
                </select><br>
                <label for="empresa_agua">empresa agua:</label>
                <select id="modificarPuesto" name="puesto" required>
                    <option value="AySA">AySA</option>
                    <option value="ABSA">ABSA</option>
                    <option value="ASSA">ASSA</option>
                    <option value="Sameep">Sameep</option>
                </select><br>
                <label for="fecha_alta">Fecha de Alta:</label>
                <input type="date" id="modificarFechaAlta" name="fecha_alta" required><br>
                <input type="submit" value="Guardar Cambios">
            </form>
        </div>
    </div>


    <div id="modalVerPDF" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalVerPDF()">&times;</span>
            <h2>Contrato PDF</h2>
            <iframe id="pdfViewer" width="100%" height="600px"></iframe>
        </div>
    </div>

    <!-- Modal para mostrar respuesta -->
    <div id="modalRespuesta">
        <div id="modal-content">
            <span id="close-button" onclick="closeModal()">&times;</span>
            <h2>Respuesta del servidor</h2>
            <div id="modal-message" width="100%" height="300px"></div>
        </div>
    </div>



    <form action="destruirsesion.php" method="post">
        <button type="submit">Terminar sesión</button>
    </form>

    <script>
        function openModal(data) {
            const messageDiv = document.getElementById('modal-message');

            if (data.status === "success") {
                messageDiv.innerHTML = `
            <p>${data.message}</p>
            <p><strong>ID:</strong> ${data.data.id}</p>
            <p><strong>Consorcio:</strong> ${data.data.consorcio}</p>
            <p><strong>Empresa de Luz:</strong> ${data.data.empresa_luz}</p>
            <p><strong>Empresa de Agua:</strong> ${data.data.empresa_agua}</p>
            <p><strong>Fecha de Renovación:</strong> ${data.data.fecha_renovacion}</p>
        `;
            } else {
                messageDiv.innerHTML = `<p>${data.message}</p>`;
            }

            document.getElementById('modalRespuesta').style.display = 'flex';
        }

        // Función para cerrar el modal
        function closeModal() {
            document.getElementById('modalRespuesta').style.display = 'none';
        }

        // Muestra el modal para agregar un nuevo servicio
        function showModalAgregar() {
            document.getElementById('modalAgregar').style.display = "block";
        }

        // Oculta el modal para agregar
        function hideModalAgregar() {
            document.getElementById('modalAgregar').style.display = "none";
        }

        // Muestra el modal para ver el PDF
        function showModalVerPDF(id) {
            document.getElementById('pdfViewer').src = `ver_pdf.php?id=${id}`;
            document.getElementById('modalVerPDF').style.display = "block";
        }

        // Oculta el modal de visualización de PDF
        function hideModalVerPDF() {
            document.getElementById('modalVerPDF').style.display = "none";
            document.getElementById('pdfViewer').src = "";
        }

        // Cargar servicios con filtros
        function cargarServicios() {
            const filtroId = document.getElementById('filtroId') ? document.getElementById('filtroId').value : '';
            const filtroConsorcio = document.getElementById('filtroConsorcio') ? document.getElementById('filtroConsorcio').value : '';
            const filtroLuz = document.getElementById('filtroLuz') ? document.getElementById('filtroLuz').value : '';
            const filtroAgua = document.getElementById('filtroAgua') ? document.getElementById('filtroAgua').value : '';
            const filtroFechaRenovacion = document.getElementById('filtroFechaRenovacion') ? document.getElementById('filtroFechaRenovacion').value : '';

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
                    const tablaResultados = document.getElementById("tablaResultados");
                    if (tablaResultados) {
                        tablaResultados.innerHTML = data;
                    } else {
                        console.error("No se encontró el contenedor 'tablaResultados'");
                    }
                })
                .catch(error => {
                    console.error("Error al cargar la tabla:", error);
                });
        }

        // Función para ver el PDF asociado a un servicio
        function verPDF(id) {
            showModalVerPDF(id);
        }

        // Función para enviar el formulario de modificación y mostrar el modal con los cambios
        document.getElementById('modificarForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch("modificar.php", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    closeModal();  // Cierra el modal de modificación
                    openModal(data);  // Muestra el modal de respuesta con los datos
                })
                .catch(error => {
                    console.error("Error al modificar el servicio:", error);
                    openModal({ status: "error", message: "Error al modificar el servicio." });
                });
        });

        // Envío del formulario para agregar un nuevo servicio
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
                })
                .catch(error => {
                    alert("Error al agregar servicio: " + error);
                });
        });

        // Función para eliminar un servicio
        function eliminarServicio(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este servicio?")) {
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
                        alert("Error al eliminar servicio: " + error);
                    });
            }
        }
        
        function limpiarFiltros() {
            const inputs = document.querySelectorAll(".filter-input");
            inputs.forEach(input => {
                if (input.type === "text" || input.tagName === "SELECT") {
                    input.value = "";
                }
            });
        }

        function borrar() {
            document.getElementById("tablaResultados").innerHTML = "";
        }
    </script>
</body>

</html>
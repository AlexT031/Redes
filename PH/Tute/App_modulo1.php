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
    <h1>Gestión de Empleados</h1>
    <button class="add-btn" onclick="showModalAgregar()">Agregar Nuevo Empleado</button>
    <button onclick="cargarEmpleados()">Cargar Tabla</button>
    <button id="borrarTableBtn" onclick="borrar()">Borrar Tabla</button>
    <button onclick="limpiarFiltros()">Limpiar Filtros</button>

    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Puesto</th>
            <th>Fecha de Alta</th>
            <th>Salario</th>
            <th>PDF</th>
            <th>Acciones</th>
        </tr>
        <tr>
            <td><input type="text" id="filtroId" class="filter-input" placeholder="Filtro ID"></td>
            <td><input type="text" id="filtroNombre" class="filter-input" placeholder="Filtro Nombre"></td>
            <td>
                <select id="filtroPuesto" class="filter-input">
                    <option value="">Todos</option>
                    <option value="Gerente">Gerente</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Asistente">Asistente</option>
                    <option value="Operario">Operario</option>
                </select>
            </td>
            <td><input type="text" id="filtroFecha" class="filter-input" placeholder="Filtro Fecha"></td>
            <td><input type="text" id="filtroSalario" class="filter-input" placeholder="Filtro Salario"></td>
            <td></td>
            <td></td>
        </tr>
        </thead>
        <tbody id="tablaResultados">
        </tbody>
    </table>



    <div id="modalModificar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalModificar()">&times;</span>
            <h2>Modificar Empleado</h2>
            <form id="modificarForm" method="POST">
                <input type="hidden" id="modificarId" name="id">
                <label for="nombre">Nombre:</label>
                <input type="text" id="modificarNombre" name="nombre" required><br>
                <label for="puesto">Puesto:</label>
                <select id="modificarPuesto" name="puesto" required>
                    <option value="Gerente">Gerente</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Asistente">Asistente</option>
                    <option value="Operario">Operario</option>
                </select><br>
                <label for="fecha_alta">Fecha de Alta:</label>
                <input type="date" id="modificarFechaAlta" name="fecha_alta" required><br>
                <label for="salario">Salario:</label>
                <input type="number" id="modificarSalario" name="salario" step="0.01" required><br>
                <input type="submit" value="Guardar Cambios">
            </form>
        </div>
    </div>

    <div id="modalAgregar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalAgregar()">&times;</span>
            <h2>Agregar Empleado</h2>
            <form id="empleadoForm" enctype="multipart/form-data" method="POST">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required><br>
                <label for="puesto">Puesto:</label>
                <select name="puesto" required>
                    <option value="Gerente">Gerente</option>
                    <option value="Supervisor">Supervisor</option>
                    <option value="Asistente">Asistente</option>
                    <option value="Operario">Operario</option>
                </select><br>
                <label for="fecha_alta">Fecha de Alta:</label>
                <input type="date" name="fecha_alta" required><br>
                <label for="salario">Salario:</label>
                <input type="number" name="salario" step="0.01" required><br>
                <label for="pdf">PDF del Contrato:</label>
                <input type="file" name="pdf" accept="application/pdf" required><br>
                <input type="submit" value="Agregar Empleado">
            </form>
        </div>
    </div>

    <div id="modalVerPDF" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideModalVerPDF()">&times;</span>
            <h2>Contrato PDF</h2>
            <iframe id="pdfViewer" width="100%" height="500px"></iframe>
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
                <p><strong>Nombre:</strong> ${data.data.nombre}</p>
                <p><strong>Puesto:</strong> ${data.data.puesto}</p>
                <p><strong>Fecha de Alta:</strong> ${data.data.fecha_alta}</p>
                <p><strong>Salario:</strong> ${data.data.salario}</p>
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

        function showModalAgregar() {
            document.getElementById('modalAgregar').style.display = "block";
        }

        function hideModalAgregar() {
            document.getElementById('modalAgregar').style.display = "none";
        }

        function showModalModificar() {
            document.getElementById('modalModificar').style.display = "block";
        }

        function hideModalModificar() {
            document.getElementById('modalModificar').style.display = "none";
        }

        function showModalVerPDF(id) {
            document.getElementById('pdfViewer').src = `ver_pdf.php?id=${id}`;
            document.getElementById('modalVerPDF').style.display = "block";
        }

        function hideModalVerPDF() {
            document.getElementById('modalVerPDF').style.display = "none";
            document.getElementById('pdfViewer').src = "";
        }


        function cargarEmpleados() {
            const filtroId = document.getElementById('filtroId') ? document.getElementById('filtroId').value : '';
            const filtroNombre = document.getElementById('filtroNombre') ? document.getElementById('filtroNombre').value : '';
            const filtroPuesto = document.getElementById('filtroPuesto') ? document.getElementById('filtroPuesto').value : '';
            const filtroFecha = document.getElementById('filtroFecha') ? document.getElementById('filtroFecha').value : '';
            const filtroSalario = document.getElementById('filtroSalario') ? document.getElementById('filtroSalario').value : '';

            const params = new URLSearchParams();
            if (filtroId) params.append("filtroId", filtroId);
            if (filtroNombre) params.append("filtroNombre", filtroNombre);
            if (filtroPuesto) params.append("filtroPuesto", filtroPuesto);
            if (filtroFecha) params.append("filtroFecha", filtroFecha);
            if (filtroSalario) params.append("filtroSalario", filtroSalario);

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



        function borrar() {
            document.getElementById("tablaResultados").innerHTML = "";
        }

        function verPDF(id) {
            showModalVerPDF(id);
        }

        function modificarEmpleado(id, nombre, puesto, fecha_alta, salario) {
            document.getElementById('modificarId').value = id;
            document.getElementById('modificarNombre').value = nombre;
            document.getElementById('modificarPuesto').value = puesto;
            document.getElementById('modificarFechaAlta').value = fecha_alta;
            document.getElementById('modificarSalario').value = salario;
            showModalModificar();
        }



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
                    console.error("Error al modificar empleado:", error);
                    openModal({ status: "error", message: "Error al modificar empleado." });
                });
        });


        document.getElementById('empleadoForm').addEventListener('submit', function (event) {
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
                    alert("Error al agregar empleado: " + error);
                });
        });

        function eliminarEmpleado(id) {
            if (confirm("¿Estás seguro de que deseas eliminar este empleado?")) {
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
                        alert("Error al eliminar empleado: " + error);
                    });
            }
        }

        function filtrarColumna(columna, input) {
            const filtro = input.value.toLowerCase();
            const tabla = document.getElementById("empleadosTable");
            const tr = tabla.getElementsByTagName("tr");
            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName("td")[columna];
                if (td) {
                    const textoValor = td.textContent || td.innerText;
                    tr[i].style.display = textoValor.toLowerCase().indexOf(filtro) > -1 ? "" : "none";
                }
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
    </script>
</body>

</html>
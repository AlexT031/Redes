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
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
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
        input[type="text"], input[type="date"], input[type="number"], input[type="file"] {
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
    <button id="cargarTableBtn" onclick="cargarEmpleados()">Cargar Tabla</button>
    <button id="borrarTableBtn" onclick="borrar()">Borrar Tabla</button>
    <button onclick="limpiarFiltros()">Limpiar Filtros</button>
    <label for="ordenar">Ordenar por:</label>
    <select id="ordenar" onchange="ordenarTabla()">
        <option value="id">ID</option>
        <option value="nombre">Nombre</option>
        <option value="puesto">Puesto</option>
        <option value="fecha_alta">Fecha de Alta</option>
        <option value="salario">Salario</option>
    </select>

    <table border="1" id="empleadosTable">
        <thead>
            <tr>
                <th>ID <input type="text" id="filtroId"></th>
                <th>Nombre <input type="text" id="filtroNombre"></th>
                <th>Puesto 
                    <select id="filtroPuesto">
                        <option value="">Todos</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Supervisor">Supervisor</option>
                        <option value="Asistente">Asistente</option>
                        <option value="Operario">Operario</option>
                    </select>
                </th>
                <th>Fecha de Alta <input type="text" id="filtroFecha"></th>
                <th>Salario <input type="text" id="filtroSalario"></th>
                <th>PDF</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="empleados-table"></tbody>
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

    <form action="destruirsesion.php" method="post">
        <button type="submit">Terminar sesión</button>
    </form>

<script>
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
            // Obtener valores de filtros
            const filtroId = document.getElementById('id').value;
            const filtroNombre = document.getElementById('filtroNombre').value;
            const filtroPuesto = document.getElementById('filtroPuesto').value;
            const filtroFecha = document.getElementById('filtroFecha').value;
            const filtroSalario = document.getElementById('filtroSalario').value;

            // Crear parámetros solo si hay valores en los filtros
            const params = new URLSearchParams();
            if (filtroId) params.append("filtroId", filtroId);
            if (filtroNombre) params.append("filtroNombre", filtroNombre);
            if (filtroPuesto) params.append("filtroPuesto", filtroPuesto);
            if (filtroFecha) params.append("filtroFecha", filtroFecha);
            if (filtroSalario) params.append("filtroSalario", filtroSalario);

            // Cargar tabla sin filtros si todos están vacíos
            const query = params.toString() ? `?${params.toString()}` : "";

            // Realizar petición usando fetch
            fetch(`listar.php${query}`)
                .then(response => response.text())
                .then(data => {
                    // Mostrar los resultados en la tabla
                    document.getElementById("tablaResultados").innerHTML = data;
                })
                .catch(error => {
                    console.error("Error al cargar la tabla:", error);
                });
        }



    function borrar() {
        document.getElementById("empleados-table").innerHTML = "";
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

    document.getElementById('modificarForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch("modificar.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            hideModalModificar();
        })
        .catch(error => {
            alert("Error al modificar empleado: " + error);
        });
    });

    document.getElementById('empleadoForm').addEventListener('submit', function(event) {
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
        const inputs = document.querySelectorAll("#empleadosTable input[type='text']");
        inputs.forEach(input => {
            input.value = "";
            filtrarColumna(Array.prototype.indexOf.call(inputs, input), input);
        });
    }

    function ordenarTabla() {
        const tabla = document.getElementById("empleadosTable");
        const filas = Array.from(tabla.rows).slice(1);
        const criterio = document.getElementById('ordenar').value;
        const indice = {
            id: 0,
            nombre: 1,
            puesto: 2,
            fecha_alta: 3,
            salario: 4
        }[criterio];
        filas.sort((a, b) => {
            const valorA = a.cells[indice].innerText;
            const valorB = b.cells[indice].innerText;
            return valorA > valorB ? 1 : -1;
        });
        filas.forEach(fila => tabla.appendChild(fila)); 
    }
</script>
</body>
</html>

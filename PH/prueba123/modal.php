<?php
?>
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

document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadMarcasYLocales();

    // Función para cargar todos los productos en la tabla
    function loadProducts() {
        fetch('read.php')
        .then(response => response.json())
        .then(products => {
            const productList = document.getElementById('productList');
            productList.innerHTML = '';
            
            products.forEach(product => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.producto}</td>
                    <td>${product.codigo}</td>
                    <td>${product.tipo}</td>
                    <td>${product.marca}</td>
                    <td>${product.local}</td>
                    <td>
                        <button class="editBtn" data-id="${product.id_producto}">Editar</button>
                        <button class="deleteBtn" data-id="${product.id_producto}">Eliminar</button>
                    </td>
                `;
                productList.appendChild(row);
            });

            // Asignar eventos a los botones de eliminar y editar
            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', deleteProduct);
            });

            document.querySelectorAll('.editBtn').forEach(button => {
                button.addEventListener('click', loadProductForEdit);
            });
        });
    }

    // Función para cargar marcas y locales en los select
    function loadMarcasYLocales() {
        fetch('getMarcasYLocales.php')
        .then(response => response.json())
        .then(data => {
            const marcasSelect = document.getElementById('id_marca');
            const localesSelect = document.getElementById('id_local');
            const updateMarcasSelect = document.getElementById('update_id_marca');
            const updateLocalesSelect = document.getElementById('update_id_local');

            // Limpiar los selects antes de agregar las nuevas opciones
            marcasSelect.innerHTML = '';
            localesSelect.innerHTML = '';
            updateMarcasSelect.innerHTML = '';
            updateLocalesSelect.innerHTML = '';

            // Agregar opciones de marcas
            data.marcas.forEach(marca => {
                let option = document.createElement('option');
                option.value = marca.id_marca;
                option.text = marca.nombre;
                marcasSelect.appendChild(option);

                // También añadir al select de actualización
                let updateOption = option.cloneNode(true);
                updateMarcasSelect.appendChild(updateOption);
            });

            // Agregar opciones de locales
            data.locales.forEach(local => {
                let option = document.createElement('option');
                option.value = local.id_local;
                option.text = local.nombre;
                localesSelect.appendChild(option);

                // También añadir al select de actualización
                let updateOption = option.cloneNode(true);
                updateLocalesSelect.appendChild(updateOption);
            });
        });
    }

    // Función para eliminar un producto
    function deleteProduct(event) {
        const id = event.target.getAttribute('data-id');

        fetch(`delete.php?id_producto=${id}`, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts(); // Recargar la lista de productos
        });
    }

    // Función para cargar los datos de un producto en el formulario de edición
    function loadProductForEdit(event) {
        const id = event.target.getAttribute('data-id');

        fetch(`getProductById.php?id_producto=${id}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('update_id_producto').value = product.id_producto;
            document.getElementById('update_nombre').value = product.nombre;
            document.getElementById('update_codigo').value = product.codigo;
            document.getElementById('update_tipo').value = product.tipo;
            document.getElementById('update_id_marca').value = product.id_marca;
            document.getElementById('update_id_local').value = product.id_local;

            // Mostrar el formulario de actualización
            document.getElementById('updateFormContainer').style.display = 'block';
        });
    }

    // Función para manejar el envío del formulario de creación de productos
    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('create.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts(); // Recargar la lista de productos
        });
    });

    // Función para manejar el envío del formulario de actualización de productos
    document.getElementById('updateForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts(); // Recargar la lista de productos
            document.getElementById('updateFormContainer').style.display = 'none'; // Ocultar el formulario de actualización
        });
    });
});

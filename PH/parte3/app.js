document.addEventListener('DOMContentLoaded', function() {
    loadProducts();
    loadMarcas();

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
                    <td>${product.marca}</td>
                    <td>
                        <button class="editBtn" data-id="${product.id_producto}">Editar</button>
                        <button class="deleteBtn" data-id="${product.id_producto}">Eliminar</button>
                    </td>
                `;
                productList.appendChild(row);
            });

            document.querySelectorAll('.deleteBtn').forEach(button => {
                button.addEventListener('click', deleteProduct);
            });

            document.querySelectorAll('.editBtn').forEach(button => {
                button.addEventListener('click', loadProductForEdit);
            });
        });
    }

    function loadMarcas() {
        fetch('getMarcas.php')
        .then(response => response.json())
        .then(marcas => {
            const marcaSelect = document.getElementById('id_marca');
            marcaSelect.innerHTML = '';
            marcas.forEach(marca => {
                let option = document.createElement('option');
                option.value = marca.id_marca;
                option.text = marca.nombre;
                marcaSelect.appendChild(option);
            });
        });
    }

    function deleteProduct(event) {
        const id = event.target.getAttribute('data-id');
        fetch(`delete.php?id_producto=${id}`, { method: 'GET' })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts();
        });
    }

    function loadProductForEdit(event) {
        const id = event.target.getAttribute('data-id');
        fetch(`getProductById.php?id_producto=${id}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('update_id_producto').value = product.id_producto;
            document.getElementById('update_nombre').value = product.nombre;
            document.getElementById('update_codigo').value = product.codigo;
            document.getElementById('update_id_marca').value = product.id_marca;
            document.getElementById('updateFormContainer').style.display = 'block';
        });
    }

    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('create.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts();
        });
    });

    document.getElementById('updateForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        fetch('update.php', { method: 'POST', body: formData })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            loadProducts();
            document.getElementById('updateFormContainer').style.display = 'none';
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    loadProducts();

    // Agregar producto
    document.getElementById('productForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('create.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(() => {
            alert('Producto agregado exitosamente');
            loadProducts();  // Recargar la lista
        });
    });

    // Cargar productos y mostrarlos en la tabla
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

    // Eliminar producto
    function deleteProduct() {
        const id_producto = this.getAttribute('data-id');
        
        fetch('delete.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_producto=${id_producto}`
        })
        .then(response => response.text())
        .then(() => {
            alert('Producto eliminado exitosamente');
            loadProducts();  // Recargar la lista
        });
    }

    // Cargar datos de producto para editar
    function loadProductForEdit() {
        const id_producto = this.getAttribute('data-id');
        
        fetch(`read.php?id_producto=${id_producto}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('id_producto').value = product.id_producto;
            document.getElementById('update_nombre').value = product.producto;
            document.getElementById('update_codigo').value = product.codigo;
            document.getElementById('update_tipo').value = product.tipo;
            document.getElementById('update_id_marca').value = product.id_marca;
            document.getElementById('update_id_local').value = product.id_local;
        });
    }

    // Actualizar producto
    document.getElementById('updateForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('update.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(() => {
            alert('Producto actualizado exitosamente');
            loadProducts();  // Recargar la lista
        });
    });
});

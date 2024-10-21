document.addEventListener('DOMContentLoaded', function() {
    loadMarcas(); // Llama a la función para cargar las marcas al cargar la página
    loadProducts(); // Llama a la función para cargar los productos

    // Manejo del evento del formulario para agregar productos
    const productForm = document.getElementById('productForm');
    productForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional
        addProduct(); // Llama a la función para agregar el producto
    });

    // Manejo del evento del formulario de actualización
    const updateForm = document.getElementById('updateForm');
    updateForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío del formulario
        updateProduct(); // Llama a la función para actualizar el producto
    });
});

// Función para cargar marcas desde el servidor
function loadMarcas() {
    fetch('getMarcas.php')
        .then(response => response.json())
        .then(marcas => {
            const marcaSelect = document.getElementById('id_marca');
            const updateMarcaSelect = document.getElementById('update_id_marca');

            marcaSelect.innerHTML = '';
            updateMarcaSelect.innerHTML = '';

            marcas.forEach(marca => {
                let option = document.createElement('option');
                option.value = marca.id_marca;
                option.text = marca.nombre;
                marcaSelect.appendChild(option);

                // Añadir opciones para el formulario de actualización
                let updateOption = document.createElement('option');
                updateOption.value = marca.id_marca;
                updateOption.text = marca.nombre;
                updateMarcaSelect.appendChild(updateOption);
            });
        })
        .catch(error => console.error('Error loading marcas:', error));
}

// Función para cargar productos desde el servidor
function loadProducts() {
    fetch('getProducts.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.text(); // Cambiar a text para manejar la respuesta cruda
    })
    .then(data => {
        if (data) {
            const products = JSON.parse(data); // Intenta analizar como JSON
            const productList = document.getElementById('productList');
            productList.innerHTML = '';

            products.forEach(product => {
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${product.nombre}</td>
                    <td>${product.codigo}</td>
                    <td>${product.nombre_marca}</td>
                    <td>
                        <button onclick="editProduct(${product.id_producto})">Editar</button>
                        <button onclick="deleteProduct(${product.id_producto})">Eliminar</button>
                    </td>
                `;
                productList.appendChild(row);
            });
        } else {
            console.error('La respuesta está vacía');
        }
    })
    .catch(error => console.error('Error loading products:', error));

}

// Función para agregar un producto
function addProduct() {
    const formData = new FormData(document.getElementById('productForm'));

    fetch('create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json()) // Cambiar a .json() para recibir un JSON válido
    .then(data => {
        if (data.success) {
            loadProducts(); // Recargar productos
            document.getElementById('productForm').reset(); // Reiniciar el formulario
        } else {
            console.error(data.message); // Manejo de errores
        }
    })
    .catch(error => console.error('Error:', error));
}

// Función para editar un producto
function editProduct(id) {
    // Lógica para obtener el producto por ID
    fetch(`getProduct.php?id=${id}`)
        .then(response => response.json())
        .then(product => {
            document.getElementById('update_id_producto').value = product.id_producto;
            document.getElementById('update_nombre').value = product.nombre;
            document.getElementById('update_codigo').value = product.codigo;
            document.getElementById('update_id_marca').value = product.id_marca;

            document.getElementById('updateFormContainer').style.display = 'block'; // Muestra el formulario de actualización
        })
        .catch(error => console.error('Error fetching product for edit:', error));
}

// Función para eliminar un producto
function deleteProduct(id) {
    if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
        fetch(`delete.php?id=${id}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadProducts(); // Recargar productos
            } else {
                console.error(data.message); // Manejo de errores
            }
        })
        .catch(error => console.error('Error deleting product:', error));
    }
}

// Función para actualizar un producto
function updateProduct() {
    const formData = new FormData(document.getElementById('updateForm'));

    fetch('update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadProducts(); // Recargar productos
            document.getElementById('updateFormContainer').style.display = 'none'; // Ocultar formulario de actualización
            document.getElementById('updateForm').reset(); // Reiniciar el formulario
        } else {
            console.error(data.message); // Manejo de errores
        }
    })
    .catch(error => console.error('Error updating product:', error));
}

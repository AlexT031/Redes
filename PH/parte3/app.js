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
        });
}

// Función para cargar productos desde el servidor
function loadProducts() {
    fetch('getProducts.php')
        .then(response => response.json())
        .then(products => {
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
        });
}

// Función para agregar un producto
function addProduct() {
    const formData = new FormData(document.getElementById('productForm'));

    fetch('create.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadProducts(); // Recargar productos
            document.getElementById('productForm').reset(); // Reiniciar el formulario
        } else {
            console.error(data.message); // Manejo de errores
        }
    });
}

// Función para editar un producto
function editProduct(id) {
    // Aquí iría la lógica para cargar los datos del producto en el formulario de actualización
}

// Función para eliminar un producto
function deleteProduct(id) {
    // Aquí iría la lógica para eliminar el producto
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
    });
}

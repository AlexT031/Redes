function reloadTable() {
    const iframe = document.getElementById('productTable');
    iframe.src = iframe.src; // Recargar el iframe
}

function openModal() {
    document.getElementById('modal').style.display = 'block';
    fetchMarcas(); // Llamar a la función para obtener marcas
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function fetchMarcas() {
    fetch('getmarcas.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_marca');
            select.innerHTML = ''; // Limpiar el select
            data.forEach(marca => {
                const option = document.createElement('option');
                option.value = marca.id_marca;
                option.textContent = marca.nombre;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error al obtener marcas:', error));
}

function confirmAddProduct(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    const nombre = document.getElementById('nombre').value;
    const codigo = document.getElementById('codigo').value;
    const idMarca = document.getElementById('id_marca').value;

    // Mostrar alerta con los datos ingresados
    const confirmationMessage = `Nombre: ${nombre}\nCódigo: ${codigo}\nID Marca: ${idMarca}`;
    if (confirm(`¿Confirmas los siguientes datos?\n\n${confirmationMessage}`)) {
        // Si se confirma, se envía el formulario
        document.querySelector('form[action="create.php"]').submit();
    }
}

function confirmDeleteProduct(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    const idProducto = document.getElementById('id_producto').value;

    // Mostrar alerta con el ID del producto a eliminar
    if (confirm(`¿Estás seguro de que deseas eliminar el producto con ID: ${idProducto}?`)) {
        // Si se confirma, se envía el formulario
        document.querySelector('form[action="delete.php"]').submit();
    }
}

// Agregar listeners al formulario
document.addEventListener('DOMContentLoaded', () => {
    const addProductForm = document.querySelector('form[action="create.php"]');
    const deleteProductForm = document.querySelector('form[action="delete.php"]');

    addProductForm.addEventListener('submit', confirmAddProduct);
    deleteProductForm.addEventListener('submit', confirmDeleteProduct);
});

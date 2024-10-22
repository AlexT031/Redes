function reloadTable() {
    const iframe = document.getElementById('productTable');
    iframe.src = iframe.src; 
}

function openModal() {
    document.getElementById('modal').style.display = 'block';
    fetchMarcas(); 
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

function fetchMarcas() {
    fetch('getmarcas.php')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('id_marca');
            select.innerHTML = '';
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
    event.preventDefault(); 

    const nombre = document.getElementById('nombre').value;
    const codigo = document.getElementById('codigo').value;
    const idMarca = document.getElementById('id_marca').value;

    
    const confirmationMessage = `Nombre: ${nombre}\nCódigo: ${codigo}\nID Marca: ${idMarca}`;
    if (confirm(`¿Confirmas los siguientes datos?\n\n${confirmationMessage}`)) {
        
        document.querySelector('form[action="create.php"]').submit();
    }
}

function confirmDeleteProduct(event) {
    event.preventDefault();
    const idProducto = document.getElementById('id_producto').value;

    if (confirm(`¿Estás seguro de que deseas eliminar el producto con ID: ${idProducto}?`)) {
        document.querySelector('form[action="delete.php"]').submit();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const addProductForm = document.querySelector('form[action="create.php"]');
    const deleteProductForm = document.querySelector('form[action="delete.php"]');

    addProductForm.addEventListener('submit', confirmAddProduct);
    deleteProductForm.addEventListener('submit', confirmDeleteProduct);
});

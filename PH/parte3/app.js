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

// Función para abrir el modal y cargar el PDF en el iframe
function openPdfModal(pdfUrl) {
    var modal = document.getElementById("pdfModal");
    var iframe = document.getElementById("pdfViewer");
    iframe.src = pdfUrl;
    modal.style.display = "block";
}

// Función para cerrar el modal
function closePdfModal() {
    var modal = document.getElementById("pdfModal");
    var iframe = document.getElementById("pdfViewer");
    iframe.src = ""; // Limpiar el src del iframe cuando se cierre el modal
    modal.style.display = "none";
}

document.getElementById('searchInput').addEventListener('input', function () {
    var searchValue = this.value.toLowerCase();
    var rows = document.querySelectorAll('table tbody tr');

    rows.forEach(function (row) {
        var productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        var productCode = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        
        if (productName.includes(searchValue) || productCode.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});


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

function openPdfModal(pdfUrl) {
    var modal = document.getElementById("pdfModal");
    var iframe = document.getElementById("pdfViewer");
    iframe.src = pdfUrl;
    modal.style.display = "block";
}

function closePdfModal() {
    var modal = document.getElementById("pdfModal");
    var iframe = document.getElementById("pdfViewer");
    iframe.src = "";
    modal.style.display = "none";
}



const searchInput = document.getElementById('searchInput');
const table = document.getElementById('productTable');
const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

searchInput.addEventListener('input', function () {
    const searchValue = searchInput.value.toLowerCase();

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const productName = row.getElementsByTagName('td')[1].textContent.toLowerCase();
        const productCode = row.getElementsByTagName('td')[2].textContent.toLowerCase(); 

        if (productName.includes(searchValue) || productCode.includes(searchValue)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    }
});


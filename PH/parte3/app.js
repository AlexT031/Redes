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

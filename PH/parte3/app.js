document.getElementById('elementForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const elementValue = document.getElementById('elementInput').value;
    
    if (elementValue) {
        fetch('backend.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ element: elementValue })
        })
        .then(response => response.json())
        .then(data => {
            updateElementList(data);
            document.getElementById('elementInput').value = '';
        });
    }
});

function updateElementList(elements) {
    const list = document.getElementById('elementList');
    list.innerHTML = '';
    elements.forEach(element => {
        const li = document.createElement('li');
        li.textContent = element.name;
        list.appendChild(li);
    });
}

window.onload = function() {
    fetch('backend.php')
    .then(response => response.json())
    .then(data => updateElementList(data));
}

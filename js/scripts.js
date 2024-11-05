document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('edit-btn');
    const finishButton = document.getElementById('finish-btn');
    const editableCells = document.querySelectorAll('.editable-cell');

    // Function to toggle editable state
    function toggleEditable(state) {
        editableCells.forEach(cell => {
            cell.contentEditable = state;
            cell.classList.toggle('editable', state); // Optional: add a class for styling
        });
    }

    // Handle Edit button click
    editButton.addEventListener('click', function() {
        toggleEditable(true);
        editButton.style.display = 'none'; // Hide Edit button
        finishButton.style.display = 'inline-block'; // Show Finish button
    });

    // Handle Finish button click
    finishButton.addEventListener('click', function() {
        const dataToUpdate = [];

        editableCells.forEach(cell => {
            const row = cell.closest('tr');
            const incomeId = row.getAttribute('data-id');
            const field = cell.getAttribute('data-field');
            const value = cell.innerText;

            dataToUpdate.push({ incomeId, field, value });
        });

        // Send the updated data to the server
        fetch('config/income_edit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dataToUpdate)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Update successful');
                toggleEditable(false); // Disable editing
                finishButton.style.display = 'none'; // Hide Finish button
                editButton.style.display = 'inline-block'; // Show Edit button again
            } else {
                console.error('Update failed:', data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});
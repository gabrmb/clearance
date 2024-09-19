// Get modal and buttons
const modal = document.getElementById('addUserModal');
const addBtn = document.querySelector('.add-btn');
const closeBtn = document.querySelector('.close');

// Open modal when Add button is clicked
addBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

// Close modal when close button is clicked
closeBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal if the user clicks outside the modal
window.addEventListener('click', (event) => {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
});

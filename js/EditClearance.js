// Get all elements
const editBtns = document.querySelectorAll('.edit-btn');
const editModal = document.getElementById('editModalForm');
const closeModal = document.querySelectorAll('.close');

// Get the input fields in the edit modal
const editName = document.getElementById('edit_name');
const editRegNo = document.getElementById('edit_regNo');
const editDepartment = document.getElementById('edit_department');
const editPhone = document.getElementById('edit_phone');
const editCourse = document.getElementById('edit_course');
const editEmail = document.getElementById('edit_email');
const editClearanceType = document.getElementById('edit_clearanceType');

// Function to populate and show the edit modal
function showEditModal(rowData) {
    document.getElementById('edit_requestID').value = rowData.RequestID; // Set RequestID
    editRegNo.value = rowData.StudentAdmNo;
    editDepartment.value = rowData.Department;
    editPhone.value = rowData.Contact;
    editCourse.value = rowData.Course;
    editEmail.value = rowData.Email;
    editClearanceType.value = rowData.ClearanceType;
    
    // Show the modal
    editModal.style.display = "block";
}


// Loop through each edit button
editBtns.forEach((button, index) => {
    button.addEventListener('click', () => {
        // Get the data from the row
        const row = button.closest('tr');
        const rowData = {
            RequestID: row.cells[1].innerText,
            StudentAdmNo: row.cells[2].innerText,
            Department: row.cells[3].innerText,
            Contact: row.cells[4].innerText,
            Course: row.cells[5].innerText,
            Email: row.cells[6].innerText,
            ClearanceType: row.cells[7].innerText,
        };
        
        // Populate the form with the row data and show the modal
        showEditModal(rowData);
    });
});

// Close modal when 'x' is clicked
closeModal.forEach(close => {
    close.addEventListener('click', () => {
        editModal.style.display = "none";
    });
});

document.getElementById('submitEdit').addEventListener('click', function (e) {
    // Prevent form submission until the confirmation is done
    e.preventDefault();

    // Show confirmation dialog
    const confirmation = confirm("Are you sure you want to update this request?");

    if (confirmation) {
        // If user clicked "Yes", submit the form
        document.getElementById('editClearanceForm').submit();
    } else {
        // If user clicked "No", close the modal
        closeEditModal(); // Assuming this function exists to close the modal
    }
});

// Function to close the edit modal (this should already be defined in your JavaScript)
function closeEditModal() {
    const editModal = document.getElementById('modalForm'); // Adjust if ID is different
    editModal.style.display = 'none';
}





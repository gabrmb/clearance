document.addEventListener('DOMContentLoaded', (event) => {
    // Function to open the modal and populate it with data
    function openModal(requestId, studentAdmNo, studentName, course, clearanceType, submissionDate) {
        // Set the modal fields with the data
        document.getElementById('RequestID').value = requestId;
        document.getElementById('StudentAdmNo').value = studentAdmNo;
        document.getElementById('StudentName').value = studentName;
        document.getElementById('Course').value = course;
        document.getElementById('ClearanceType').value = clearanceType;
        document.getElementById('SubmissionDate').value = submissionDate;
        document.getElementById('Status').value = 'Pending'; // Set default status
        
        // Show the modal
        document.getElementById('approveModal').style.display = 'block';
    }

    // Close the modal when the user clicks the close button
    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('approveModal').style.display = 'none';
    });

    // Handle the click event on "Approve Request" buttons
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Get data attributes
            const requestId = this.getAttribute('data-requestid');
            const studentAdmNo = this.getAttribute('data-studentadmno');
            const studentName = this.getAttribute('data-studentname');
            const course = this.getAttribute('data-course');
            const clearanceType = this.getAttribute('data-clearancetype');
            const submissionDate = this.getAttribute('data-submissiondate');
            
            // Open the modal with the data
            openModal(requestId, studentAdmNo, studentName, course, clearanceType, submissionDate);
        });
    });

//     // Handle form submission
//     document.getElementById('approveForm').addEventListener('submit', function(event) {
//         event.preventDefault(); // Prevent form from submitting normally
        
//         // Get form data
//         const formData = new FormData(this);

//         // Send an AJAX request to process the request
//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', 'process_request.php', true);
//         xhr.setRequestHeader('Accept', 'application/json');
//         xhr.onload = function() {
//             if (xhr.status === 200) {
//                 // Close the modal and reload the page or update the table
//                 document.getElementById('approveModal').style.display = 'none';
//                 location.reload(); // Reload the page to show updated data
//             } else {
//                 alert('An error occurred while processing the request.');
//             }
//         };
//         xhr.send(new URLSearchParams(formData).toString());
//     });
});

document.addEventListener("DOMContentLoaded", function() {
    fetch('fetchStatusData.php')
        .then(response => response.json())
        .then(data => {
            const tableBody = document.querySelector("#clearanceTable tbody");

            data.forEach(row => {
                const tr = document.createElement("tr");

                tr.innerHTML = `
                    <td>${row.RequestID}</td>
                    <td>${row.StudentAdmNo}</td>
                    <td>${row.ClearanceType}</td>
                    <td>${row.SubmissionDate}</td>
                    <td>${row.ProcessedBy}</td>
                    <td>${row.Status}</td>
                `;

                tableBody.appendChild(tr);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});

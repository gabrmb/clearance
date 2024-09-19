// ManageUsers.js

// Function to filter the number of entries displayed on the page
function filterEntries() {
    const select = document.getElementById("entries-select");
    const table = document.getElementById("users-table").getElementsByTagName("tbody")[0];
    const rows = table.getElementsByTagName("tr");

    const value = parseInt(select.value);
    for (let i = 0; i < rows.length; i++) {
        rows[i].style.display = i < value ? "" : "none";
    }
}

// Function to search the table
function searchTable() {
    const input = document.getElementById("search-input");
    const filter = input.value.toLowerCase();
    const table = document.getElementById("users-table");
    const tr = table.getElementsByTagName("tr");

    for (let i = 0; i < tr.length; i++) {
        const td = tr[i].getElementsByTagName("td");
        let found = false;

        for (let j = 0; j < td.length; j++) {
            if (td[j]) {
                if (td[j].innerText.toLowerCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }

        tr[i].style.display = found ? "" : "none";
    }
}

// Initialize the table display based on default entries value
document.addEventListener("DOMContentLoaded", function () {
    filterEntries();
});

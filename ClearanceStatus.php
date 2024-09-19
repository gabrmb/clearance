
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clearance Status</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/Master.css">
    <link rel="stylesheet" href="css/ClearanceStatus.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


   
</head>
<body>
    <?php include 'MasterStudent.php'; ?>

    <div class="Report">
    <form method="POST" action="">
        <div class="form-Details">
            <!-- Removed the Registration Number input field since we are using the session value -->

            <button type="submit" name="generateClearance">Generate Clearance</button>
            <button type="button" onclick="downloadClearance()">Download</button>
            <button type="button" onclick="printClearance()">Print</button>
        </div>
    </form>
</div>

<div class="printClearance">
    <div class="LetterHead">
        <img src="images/KinapLogo.jpg" alt="Company Logo">
    </div>

    <div class="StudentDetails">
        <h3>Student Clearance Report</h3>
        <div class="student-fields">
            <?php
            if (isset($_POST['generateClearance'])) {
                // Using the session value for the Registration Number
                $regNo = $_SESSION['RegNo'];

                // Database connection (update with your credentials)
                $conn = new mysqli("localhost", "root", "", "kinapclearance");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to search for the student details based on Registration No from session
                $sql = "SELECT StudentName, StudentRegNo, Course, Department, ClearanceType FROM students WHERE StudentRegNo = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $regNo);
                $stmt->execute();
                $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Display the student's details
                        while ($row = $result->fetch_assoc()) {
                            echo "<p><strong>Student Name:</strong> " . $row['StudentName'] . "</p>";
                            echo "<p><strong>Registration No:</strong> " . $row['StudentRegNo'] . "</p>";
                            echo "<p><strong>Course:</strong> " . $row['Course'] . "</p>";
                            echo "<p><strong>Department:</strong> " . $row['Department'] . "</p>";
                            echo "<p><strong>Clearance Type:</strong> " . $row['ClearanceType'] . "</p>";
                        }
                    } else {
                        echo "<p>No student found with that registration number.</p>";
                    }

                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
            <div class="student-data">
                <?php
                

                    // Database connection (update with your credentials)
                    $conn = new mysqli("localhost", "root", "", "kinapclearance");

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Query to fetch approval details based on Registration No
                    $sql_approval = "SELECT ApprovalID, Department, RequestID, RequestStatus, ApprovalDate FROM approval WHERE RegistrationNo = ?";
                    $stmt_approval = $conn->prepare($sql_approval);
                    $stmt_approval->bind_param("s", $regNo);
                    $stmt_approval->execute();
                    $result_approval = $stmt_approval->get_result();

                    if ($result_approval->num_rows > 0) {
                        // Start building the table with table head and body
                        echo "<table border='1' cellpadding='5' cellspacing='0'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>#</th>"; // Numbering column
                        echo "<th>Approval ID</th>";
                        echo "<th>Cleared by (Department)</th>";
                        echo "<th>Request ID</th>";
                        echo "<th>Request Status</th>";
                        echo "<th>Approval Date</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";

                        // Display approval details with numbering
                        $count = 1;
                        while ($row_approval = $result_approval->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $count++ . "</td>"; // Increment the number for each row
                            echo "<td>" . $row_approval['ApprovalID'] . "</td>";
                            echo "<td>" . $row_approval['Department'] . "</td>";
                            echo "<td>" . $row_approval['RequestID'] . "</td>";
                            echo "<td>" . $row_approval['RequestStatus'] . "</td>";
                            echo "<td>" . $row_approval['ApprovalDate'] . "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                    } else {
                        echo "<p>No approval records found for this student.</p>";
                    }

                    $stmt_approval->close();
                    $conn->close();
                
                ?>
            </div>
            <div class="Signature">
                <div class="registrar">
                    <hr style="border: 1px solid black; width: 110%;">
                    <p>Registrar's Signature</p>
                </div>
                <div class="date-stamp">
                    <hr style="border: 1px solid black; width: 110%;">
                    <p>Date and Stamp</p>
                </div>
            </div>
        
        </div>
    </div>

    <!-- <script>
        function downloadClearance() {
            alert("Download Clearance");
        }

        // function printClearance() {
        //     window.print();
        // }
    </script> -->

    <script>
        function printClearance() {
            var printContent = document.querySelector('.printClearance').innerHTML;
            var originalContent = document.body.innerHTML;

            // Replace the body's content with the print section's content
            document.body.innerHTML = printContent;

            // Trigger the print
            window.print();

            // Restore the original content after printing
            document.body.innerHTML = originalContent;
        }
    </script>

    <script>
        function downloadClearance() {
            const element = document.querySelector('.printClearance');
            
            // Use html2canvas to convert the div to a canvas
            html2canvas(element).then((canvas) => {
                // Get the canvas image data
                const imgData = canvas.toDataURL('image/png');
                
                // Create a new jsPDF instance
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');

                // Calculate image dimensions to fit in A4
                const imgWidth = 210; // A4 width in mm
                const pageHeight = 297; // A4 height in mm
                const imgHeight = canvas.height * imgWidth / canvas.width;

                let heightLeft = imgHeight;
                let position = 0;

                // Add the image to the PDF and handle page splitting if content overflows
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;

                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }

                // Save the PDF
                pdf.save('ClearanceReport.pdf');
            });
        }
    </script>

</body>
</html>
